<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Customer;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $user = $request->user();
        $customer = Customer::where('id', $user->id)->first();
        $payment_types = ['MBWAY', 'VISA', 'PAYPAL'];

        return view('profile.edit', [
            'user' => $user,
            'customer' => $customer,
            'payment_types' => $payment_types
        ]);
    }


    /**
     * Update the user's profile information.
     */

    public function update(ProfileUpdateRequest $request)
    {
        $validatedData = $request->validated();

        $user = Auth::user();

        $customer = DB::transaction(function () use ($validatedData, $request, $user) {
            $customer = Customer::where('id', $user->id)->first();

            if (!$customer) {
                $customer = new Customer();
                $customer->id = $user->id;
            }

            $customer->nif = $validatedData['nif'];
            $customer->payment_type = $validatedData['payment_type'];
            $customer->payment_ref = $validatedData['payment_ref'];

            $customer->save();

            $user->name = $validatedData['name'];
            $user->email = $validatedData['email'];

            if ($request->hasFile('photo_filename')) {
                if ($user->photo_filename && Storage::exists('public/photos/' . $user->photo_filename)) {
                    Storage::delete('public/photos/' . $user->photo_filename);
                }
                $path = $request->file('photo_filename')->store('public/photos');
                if (!$path) {
                    throw new \Exception("Failed to store photo");
                }
                $user->photo_filename = basename($path);
            }

            if ($user->isDirty('email')) {
                $user->email_verified_at = null;
            }

            $user->save();

            return $customer;
        });

        return view('profile.edit', [
            'status' => 'profile-updated',
            'customer' => $customer
        ]);
    }


    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
