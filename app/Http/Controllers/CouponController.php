<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function index()
    {
        $coupons = Coupon::latest()->get();

        return view('admin.coupons', compact('coupons'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => ['required', 'string', 'unique:coupons,code', 'max:50'],
            'type' => ['required', 'in:percentage,fixed'],
            'value' => ['required', 'numeric', 'min:0'],
            'usage_limit' => ['nullable', 'integer', 'min:1'],
        ]);

        Coupon::create([
            'code' => strtoupper(trim($request->code)),
            'type' => $request->type,
            'value' => $request->value,
            'usage_limit' => $request->usage_limit,
        ]);

        return back()->with('success', 'Cupom gerado com sucesso!');
    }

    public function destroy(Coupon $coupon)
    {
        $coupon->delete();

        return back()->with('success', 'Cupom excluído com sucesso.');
    }

    public function check(\Illuminate\Http\Request $request)
    {
        $coupon = \App\Models\Coupon::where('code', strtoupper($request->code))->first();

        if (!$coupon || !$coupon->isValid()) {
            return response()->json([
                'valid' => false,
                'message' => 'Cupom inválido, expirado ou esgotado.'
            ]);
        }

        return response()->json([
            'valid' => true,
            'type' => $coupon->type,
            'value' => $coupon->value,
        ]);
    }
}
