<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index(): View
    {
        $orders = Order::where('user_id', auth()->id())
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('my-orders.index', compact('orders'));
    }

    public function show(Order $order): View
    {
        abort_unless($order->user_id === auth()->id(), 403);

        $order->load(['orderItems.product', 'payment']);

        return view('my-orders.show', compact('order'));
    }

    public function cancel(Order $order): RedirectResponse
    {
        abort_unless($order->user_id === auth()->id(), 403);

        if (! in_array($order->status, ['pending_payment', 'payment_submitted'], true)) {
            return redirect()
                ->route('my-orders.index')
                ->with('error', 'Pesanan tidak dapat dibatalkan karena pembayaran sudah disetujui.');
        }

        $order->update([
            'status'        => 'cancelled',
            'cancelled_at'  => now(),
        ]);

        return redirect()
            ->route('my-orders.index')
            ->with('success', 'Pesanan berhasil dibatalkan.');
    }
}
