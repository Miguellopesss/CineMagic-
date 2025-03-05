<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\AdminFormRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function index(Request $request) : View
    {
        $adminQuery = User::where('type', 'A');

        if ($request->has('nome') && !empty($request->get('nome'))) {
            $adminQuery->where('name', 'like', '%' . $request->get('nome') . '%');
        }

        if ($request->has('mail') && !empty($request->get('mail'))) {
            $adminQuery->where('email', 'like', '%' . $request->get('mail') . '%');
        }

        $allAdmins = $adminQuery->paginate(10)->appends($request->query());

        return view('admins.index', compact('allAdmins'));
    }

    public function show(User $admin): View
    {
        return view('admins.show')->with('admin', $admin);
    }

    public function edit($id): View
    {
        $admin = User::findOrFail($id);
        return view('admins.edit', compact('admin'));
    }

    public function update(AdminFormRequest $request, User $admin): RedirectResponse
    {
        $validatedData = $request->validated();

        DB::transaction(function () use ($validatedData, $request, $admin) {
            $admin->name = $validatedData['name'];
            $admin->email = $validatedData['email'];
            $admin->blocked = $validatedData['blocked'];

            if ($request->hasFile('photo_filename')) {
                if ($admin->photo_filename && Storage::exists('public/photos/' . $admin->photo_filename)) {
                    Storage::delete('public/photos/' . $admin->photo_filename);
                }
                $path = $request->file('photo_filename')->store('public/photos');
                if (!$path) {
                    throw new \Exception("Failed to store photo");
                }
                $admin->photo_filename = basename($path);
            }

            $admin->save();
            return $admin;
        });

        $url = route('admins.show', ['admin' => $admin]);
        $htmlMessage = "Administrador <a href='$url'><u>{$admin->name}</u></a> foi atualizado com sucesso!";

        return redirect()->route('admins.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', $htmlMessage);
    }

    public function create(): View
    {
        $newAdmin = new User();
        return view('admins.create')->with('admin', $newAdmin);
    }

    public function store(AdminFormRequest $request): RedirectResponse
    {
        $validatedData = $request->validated();

        $newAdmin = DB::transaction(function () use ($validatedData, $request) {
            $newAdmin = new User();
            $newAdmin->type = 'A';
            $newAdmin->name = $validatedData['name'];
            $newAdmin->email = $validatedData['email'];
            $newAdmin->password = bcrypt('123');
            $newAdmin->blocked = $validatedData['blocked'];
            $newAdmin->save();

            if ($request->hasFile('photo_filename')) {
                $path = $request->photo_filename->store('public/photos');
                $newAdmin->photo_filename = basename($path);
                $newAdmin->save();
            }

            return $newAdmin;
        });

        $url = route('admins.show', ['admin' => $newAdmin]);
        $htmlMessage = "Administrador <a href='$url'><u>{$newAdmin->name}</u></a> foi criado com sucesso!";

        return redirect()->route('admins.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', $htmlMessage);
    }

    public function destroy(User $admin): RedirectResponse
    {
        try {
            $admin->delete();

            $url = route('admins.show', ['admin' => $admin]);
            $alertType = 'success';
            $alertMsg = "Empregado <a href='$url'><u>{$admin->name}</u></a> ({$admin->email}) foi excluído com sucesso!";
        } catch (\Exception $error) {
            $alertType = 'danger';
            $alertMsg = "Não foi possível excluir o empregado <a href='$url'><u>{$admin->name}</u></a> ({$admin->email}) devido a um erro na operação!";
        }

        return redirect()->route('admins.index')
            ->with('alert-type', $alertType)
            ->with('alert-msg', $alertMsg);
    }

    public function destroyPhoto(User $admin): RedirectResponse
    {
        if ($admin->photo_filename) {
            if (Storage::fileExists('public/photos/' . $admin->photo_filename)) {
                Storage::delete('public/photos/' . $admin->photo_filename);
            }
            $admin->photo_filename = null;
            $admin->save();
            return redirect()->back()
                ->with('alert-type', 'success')
                ->with('alert-msg', "Foto do administrador {$admin->name} foi eliminada.");
        }
        return redirect()->back();
    }

}
