<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\StorePaymentRequest;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PaymentController extends Controller
{
    public function store(StorePaymentRequest $request, Order $order): RedirectResponse
    {
        abort_unless($order->user_id === auth()->id(), 403);

        if (!in_array($order->status, ['pending_payment', 'payment_submitted'])) {
            return back()->with('error', 'Pesanan ini tidak dapat menerima pembayaran.');
        }

        $proofPath = $request->file('proof_image')->store('payments', 'public');

        try {
            DB::transaction(function () use ($order, $request, $proofPath) {
                $existingPayment = $order->payment;

                if ($existingPayment) {
                    if ($existingPayment->proof_image_path && Storage::disk('public')->exists($existingPayment->proof_image_path)) {
                        Storage::disk('public')->delete($existingPayment->proof_image_path);
                    }

                    $existingPayment->update([
                        'payer_name'       => $request->payer_name,
                        'bank_name'        => $request->bank_name,
                        'amount'           => $request->amount,
                        'proof_image_path' => $proofPath,
                        'status'           => 'submitted',
                        'submitted_at'     => now(),
                    ]);
                } else {
                    $order->payment()->create([
                        'payer_name'       => $request->payer_name,
                        'bank_name'        => $request->bank_name,
                        'amount'           => $request->amount,
                        'proof_image_path' => $proofPath,
                        'status'           => 'submitted',
                        'submitted_at'     => now(),
                    ]);
                }

                $order->update([
                    'status'               => 'payment_submitted',
                    'payment_submitted_at' => now(),
                ]);
            });
        } catch (\Throwable $e) {
            Storage::disk('public')->delete($proofPath);
            throw $e;
        }

        return redirect()->route('my-orders.show', $order)->with('success', 'Bukti pembayaran berhasil diunggah.');
    }
}
