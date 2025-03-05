<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\EmployeeFormRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class EmployeeScreeningController extends Controller
{
    public function index(Request $request): View
    {
        $employeeQuery = User::where('type', 'E');

        if ($request->has('nome') && !empty($request->get('nome'))) {
            $employeeQuery->where('name', 'like', '%' . $request->get('nome') . '%');
        }

        if ($request->has('mail') && !empty($request->get('mail'))) {
            $employeeQuery->where('email', 'like', '%' . $request->get('mail') . '%');
        }

        $allEmployees = $employeeQuery->paginate(10)->appends($request->query());

        return view('employees.index', compact('allEmployees'));
    }

    public function show(User $employee): View
    {
        return view('employees.show')->with('employee', $employee);
    }

    public function edit($id): View
    {
        $employee = User::findOrFail($id);
        return view('employees.edit', compact('employee'));
    }

    public function update(EmployeeFormRequest $request, User $employee): RedirectResponse
    {
        $validatedData = $request->validated();

        $employee = DB::transaction(function () use ($validatedData, $request, $employee) {
            $employee->name = $validatedData['name'];
            $employee->email = $validatedData['email'];
            $employee->blocked = $validatedData['blocked'];

            if ($request->hasFile('photo_filename')) {
                if ($employee->photo_filename && Storage::exists('public/photos/' . $employee->photo_filename)) {
                    Storage::delete('public/photos/' . $employee->photo_filename);
                }
                $path = $request->file('photo_filename')->store('public/photos');
                if (!$path) {
                    throw new \Exception("Failed to store photo");
                }
                $employee->photo_filename = basename($path);
            }

            $employee->save();
            return $employee;
        });

        $url = route('employees.show', ['employee' => $employee]);
        $htmlMessage = "Empregado <a href='$url'><u>{$employee->name}</u></a> foi atualizado com sucesso!";

        return redirect()->route('employees.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', $htmlMessage);
    }

    public function create(): View
    {
        $newEmployee = new User();
        return view('employees.create')->with('employee', $newEmployee);
    }

    public function store(EmployeeFormRequest $request): RedirectResponse
    {
        $validatedData = $request->validated();

        $newEmployee = DB::transaction(function () use ($validatedData, $request) {
            $newEmployee = new User();
            $newEmployee->type = 'E';
            $newEmployee->name = $validatedData['name'];
            $newEmployee->email = $validatedData['email'];
            $newEmployee->password = bcrypt('123');
            $newEmployee->blocked = $validatedData['blocked'];
            $newEmployee->save();

            if ($request->hasFile('photo_filename')) {
                $path = $request->photo_filename->store('public/photos');
                $newEmployee->photo_filename = basename($path);
                $newEmployee->save();
            }

            return $newEmployee;
        });

        $url = route('employees.show', ['employee' => $newEmployee]);
        $htmlMessage = "Empregado <a href='$url'><u>{$newEmployee->name}</u></a> foi criado com sucesso!";

        return redirect()->route('employees.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', $htmlMessage);
    }

    public function destroy(User $employee): RedirectResponse
    {
        try {
            $employee->delete();

            $url = route('employees.show', ['employee' => $employee]);
            $alertType = 'success';
            $alertMsg = "Empregado <a href='$url'><u>{$employee->name}</u></a> ({$employee->email}) foi excluído com sucesso!";
        } catch (\Exception $error) {
            $alertType = 'danger';
            $alertMsg = "Não foi possível excluir o empregado <a href='$url'><u>{$employee->name}</u></a> ({$employee->email}) devido a um erro na operação!";
        }

        return redirect()->route('employees.index')
            ->with('alert-type', $alertType)
            ->with('alert-msg', $alertMsg);
    }

    public function destroyPhoto(User $employee): RedirectResponse
    {
        if ($employee->photo_filename) {
            if (Storage::fileExists('public/photos/' . $employee->photo_filename)) {
                Storage::delete('public/photos/' . $employee->photo_filename);
            }
            $employee->photo_filename = null;
            $employee->save();
            return redirect()->back()
                ->with('alert-type', 'success')
                ->with('alert-msg', "Foto do funcionario {$employee->name} foi eliminada.");
        }
        return redirect()->back();
    }
}
