<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function showPayment(Order $order)
    {
        $order->load('items');
        return view('kasir.payment', compact('order'));
    }

    public function payCash(Request $request, Order $order)
    {
        $request->validate([
            'paid_amount' => 'required|numeric|min:0'
        ]);

        if ($order->status !== 'pending') {
            return back()->with('error', 'Order sudah selesai atau dibatalkan.');
        }

        DB::transaction(function() use ($request, $order) {
            $paid = (int) $request->paid_amount;
            $change = $paid - (int) $order->total_price;
            if ($change < 0) {
                // validasi: uang kurang
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'paid_amount' => ['Uang yang dibayar kurang dari total.']
                ]);
            }
            $order->update([
                'payment_method' => 'cash',
                'paid_amount' => $paid,
                'change_amount' => $change,
                'status' => 'paid'
            ]);
        });

        return redirect()->route('kasir.payment', $order->id)->with('success','Pembayaran tunai berhasil.');
    }

    public function confirmQris(Request $request, Order $order)
    {
        if ($order->status !== 'pending') {
            return back()->with('error','Order sudah selesai.');
        }

        // Untuk demo: kasir menekan confirm setelah customer bayar (manual)
        $order->update([
            'payment_method' => 'qris',
            'paid_amount' => $order->total_price,
            'change_amount' => 0,
            'status' => 'paid'
        ]);

        return redirect()->route('kasir.payment', $order->id)->with('success','Pembayaran QRIS dikonfirmasi.');
    }
}
