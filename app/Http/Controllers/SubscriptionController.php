<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Enums\PlanTier;

class SubscriptionController extends Controller
{
    public function checkout(Request $request, $plan, $cycle)
    {
        $user = $request->user();

        // 1. Definição de Preços e Frequência
        if ($plan === 'basic') {
            $reason = $cycle === 'annual' ? 'Rent.app - Plano Básico (Anual)' : 'Rent.app - Plano Básico (Mensal)';
            $amount = $cycle === 'annual' ? 71.88 : 9.99;
            $frequency = $cycle === 'annual' ? 12 : 1;
        } elseif ($plan === 'premium') {
            $reason = $cycle === 'annual' ? 'Rent.app - Plano Premium (Anual)' : 'Rent.app - Plano Premium (Mensal)';
            $amount = $cycle === 'annual' ? 179.88 : 19.99;
            $frequency = $cycle === 'annual' ? 12 : 1;
        } else {
            return back()->with('error', 'Plano inválido.');
        }

        if ($request->filled('coupon_code')) {
            $coupon = \App\Models\Coupon::where('code', strtoupper($request->coupon_code))->first();

            if (! $coupon || ! $coupon->isValid()) {
                return redirect()->route('plans.index')->with('error', 'Cupom inválido, expirado ou com limite de uso atingido.');
            }

            // Apply the math
            $amount = $coupon->calculateDiscount($amount);

            // Increment the usage tracker on the database
            $coupon->increment('used_count');
        }

        // 2. Chamada ao Mercado Pago
        $response = Http::withoutVerifying()
            ->withToken(env('MERCADOPAGO_ACCESS_TOKEN'))
            ->post('https://api.mercadopago.com/preapproval', [
                'reason' => $reason,
                'external_reference' => (string) $user->id,
                'payer_email' => $user->email,
                'auto_recurring' => [
                    'frequency' => $frequency,
                    'frequency_type' => 'months',
                    'transaction_amount' => $amount,
                    'currency_id' => 'BRL'
                ],
                // Update the back_url to our new callback route, passing the chosen plan
                'back_url' => route('plans.callback', ['plan' => $plan, 'cycle' => $cycle]),
                'status' => 'pending'
            ]);

        if ($response->successful()) {
            return redirect()->away($response->json('init_point'));
        }

        \Log::error('Mercado Pago Assinatura Erro: ' . $response->body());
        return back()->with('error', 'Não foi possível gerar o link de pagamento.');
    }

    // NEW METHOD: Handles the return from Mercado Pago
    public function callback(Request $request, $plan, $cycle)
    {
        $user = $request->user();
        $subscriptionId = $request->query('preapproval_id');

        if ($plan && $subscriptionId) {
            // Calculate the initial expiration date based on the cycle
            $expiresAt = $cycle === 'annual' ? now()->addYear() : now()->addMonth();

            $user->update([
                'plan_tier' => $plan === 'premium' ? \App\Enums\PlanTier::Premium : \App\Enums\PlanTier::Basic,
                'mp_subscription_id' => $subscriptionId,
                'plan_expires_at' => $expiresAt,
            ]);

            return redirect()->route('dashboard')->with('success', 'Assinatura ativada com sucesso!');
        }

        return redirect()->route('plans.index')->with('error', 'Assinatura não concluída.');
    }

    public function webhook(Request $request)
    {
        $type = $request->input('type') ?? $request->query('topic');
        $id = $request->input('data.id') ?? $request->query('id');

        if ($type === 'subscription_preapproval' && $id) {
            $response = Http::withoutVerifying()
                ->withToken(env('MERCADOPAGO_ACCESS_TOKEN'))
                ->get("https://api.mercadopago.com/preapproval/{$id}");

            if ($response->successful()) {
                $subscription = $response->json();
                $userId = $subscription['external_reference'];
                $status = $subscription['status'];
                $reason = $subscription['reason'];

                $user = \App\Models\User::find($userId);

                if ($user) {
                    if ($status === 'authorized') {
                        $plan = str_contains(strtolower($reason), 'premium')
                            ? \App\Enums\PlanTier::Premium
                            : \App\Enums\PlanTier::Basic;

                        // Parse Mercado Pago's next billing date, fallback to logic if missing
                        $isAnnual = str_contains(strtolower($reason), 'anual');
                        $fallbackDate = $isAnnual ? now()->addYear() : now()->addMonth();
                        $nextPaymentDate = isset($subscription['next_payment_date'])
                            ? \Carbon\Carbon::parse($subscription['next_payment_date'])
                            : $fallbackDate;

                        $user->update([
                            'plan_tier' => $plan,
                            'mp_subscription_id' => $id,
                            'plan_expires_at' => $nextPaymentDate,
                        ]);
                    } elseif (in_array($status, ['cancelled', 'paused'])) {
                        // Keep plan_expires_at intact so they can use the remainder of their paid time,
                        // but you can clear the tier immediately if preferred.
                        $user->update(['plan_tier' => \App\Enums\PlanTier::Free]);
                    }
                }
            }
        }

        return response()->json(['status' => 'success'], 200);
    }
}
