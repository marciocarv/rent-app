<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

class ProfileController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $subscriptionData = null;

        // If the user has an active MP subscription, fetch the real-time details
        if ($user->mp_subscription_id) {
            $response = Http::withoutVerifying()
                ->withToken(env('MERCADOPAGO_ACCESS_TOKEN'))
                ->get("https://api.mercadopago.com/preapproval/{$user->mp_subscription_id}");

            if ($response->successful()) {
                $subscriptionData = $response->json();
            }
        }

        return view('profile.index', [
            'user' => $user,
            'subscription' => $subscriptionData,
        ]);
    }

    public function updatePassword(Request $request)
    {
        // Validate the passwords
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'min:8', 'confirmed'], // 'confirmed' expects a 'password_confirmation' field
        ]);

        // Encrypt and save the new password
        $request->user()->update([
            'password' => Hash::make($request->password)
        ]);

        return back()->with('success', 'Senha atualizada com sucesso!');
    }
}
