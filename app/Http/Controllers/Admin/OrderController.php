<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\OrderCancelService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function __construct(private OrderCancelService $cancelService) {}

    public function index(Request $request): View
    {
        $query = Order::with(['user', 'orderItems.product'])
            ->orderByDesc('created_at');

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('order_code', 'like', "%{$search}%")
                    ->orWhereHas('user', fn ($u) => $u->where('name', 'like', "%{$search}%")->orWhere('email', 'like', "%{$search}%"));
            });
        }

        $orders = $query->paginate(15)->withQueryString();

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order): View
    {
        $order->load(['user', 'orderItems.product', 'payment']);

        return view('admin.orders.show', compact('order'));
    }

    public function markReady(Order $order): RedirectResponse
    {
        if ($order->status !== 'confirmed') {
            return back()->with('error', 'Hanya pesanan yang sudah dikonfirmasi yang dapat ditandai siap diambil.');
        }

        $order->update([
            'status'   => 'ready',
            'ready_at' => now(),
        ]);

        return back()->with('success', 'Pesanan ditandai siap diambil.');
    }

    public function markPickedUp(Order $order): RedirectResponse
    {
        if ($order->status !== 'ready') {
            return back()->with('error', 'Hanya pesanan yang sudah siap diambil yang dapat ditandai telah diambil.');
        }

        $order->update([
            'status'       => 'picked_up',
            'picked_up_at' => now(),
        ]);

        return back()->with('success', 'Pesanan ditandai telah diambil.');
    }

    public function cancel(Order $order): RedirectResponse
    {
        try {
            $cancelNote = $request->input('cancel_note');
            $this->cancelService->cancel($order, (int) auth()->id());
            return back()->with('success', 'Pesanan berhasil dibatalkan.');
        } catch (\RuntimeException $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
