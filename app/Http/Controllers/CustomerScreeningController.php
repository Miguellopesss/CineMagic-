<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Customer;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use App\Http\Requests\CustomerFormRequest;
use Illuminate\Http\RedirectResponse;

class CustomerScreeningController extends Controller
{
    public function index(Request $request) : View
    {
        // Query para buscar os clientes
        $customerQuery = User::where('type', 'C');

        if ($request->has('nome') && !empty($request->get('nome'))) {
            $customerQuery->where('name', 'like', '%' . $request->get('nome') . '%');
        }

        if ($request->has('mail') && !empty($request->get('mail'))) {
            $customerQuery->where('email', 'like', '%' . $request->get('mail') . '%');
        }

        $allCustomers = $customerQuery->paginate(10)->appends($request->query());

        return view('customers.index', compact('allCustomers'));
    }

    public function show(User $customer): View
    {
        return view('customers.show')->with('customer', $customer);
    }

    public function edit($id): View
    {
        $customer = User::findOrFail($id);
        return view('customers.edit', compact('customer'));
    }

    public function update(CustomerFormRequest $request, User $customer): RedirectResponse
    {
        $customer->update($request->validated());
        $url = route('customers.show', ['customer' => $customer]);
        $htmlMessage = "Cliente <a href='$url'><u>{$customer->name}</u></a> ({$customer->email}) has been updated successfully!";
        return redirect()->route('customers.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', $htmlMessage);
    }

    public function destroy(Customer $customer): RedirectResponse
    {
        try {
            $customer->delete();

            $user = User::findOrFail($customer->id);
            $user->delete();

            $url = route('customers.show', ['customer' => $customer]);
            $alertType = 'success';
            $alertMsg = "Cliente <a href='$url'><u>{$user->name}</u></a> ({$user->email}) foi apagado com sucesso!";
        } catch (\Exception $error) {
            $alertType = 'danger';
            $alertMsg = "Não foi possível eliminar o cliente <a href='$url'><u>{$user->name}</u></a> devido a um erro na operação!";
        }

        return redirect()->route('customers.index')
            ->with('alert-type', $alertType)
            ->with('alert-msg', $alertMsg);
    }
}

