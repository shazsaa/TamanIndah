<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\RejectPaymentRequest;
use App\Models\Payment;
use App\Services\PaymentApprovalService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PaymentController extends Controller
{
    public function __construct(private PaymentApprovalService $approvalService) {}

    public function index(Request $request): View
    {
        $query = Payment::with(['order.user', 'order.orderItems'])
            ->orderByDesc('submitted_at');

        if ($request->input('status') === 'pending') {
            $query->where('status', 'submitted');
        } elseif ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->whereHas('order', function ($q) use ($search) {
                $q->where('order_code', 'like', "%{$search}%")
                    ->orWhereHas('user', fn ($u) => $u->where('name', 'like', "%{$search}%")->orWhere('email', 'like', "%{$search}%"));
            });
        }

        $payments = $query->paginate(15)->withQueryString();

        return view('admin.payments.index', compact('payments'));
    }

    public function show(Payment $payment): View
    {
        $payment->load(['order.user', 'order.orderItems.product']);

        return view('admin.payments.show', compact('payment'));
    }

    public function approve(Payment $payment): RedirectResponse
    {
        try {
            $this->approvalService->approve($payment, (int) auth()->id());
            return redirect()->route('admin.payments.index')->with('success', 'Pembayaran berhasil disetujui. Stok telah dikurangi.');
        } catch (\RuntimeException $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function reject(RejectPaymentRequest $request, Payment $payment): RedirectResponse
    {
        try {
            $this->approvalService->reject($payment, $request->admin_note, (int) auth()->id());
            return redirect()->route('admin.payments.index')->with('success', 'Pembayaran ditolak.');
        } catch (\RuntimeException $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
