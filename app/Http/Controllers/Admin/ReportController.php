<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class ReportController extends Controller
{
    public function sales(Request $request): View
    {
        $orders = $this->pickedUpOrdersQuery($request)->get();

        $totalTransactions = $orders->count();
        $totalRevenue = $orders->sum('total_amount');
        $reportRows = $this->buildSalesReportRows($orders);

        return view('admin.reports.sales', compact('totalTransactions', 'totalRevenue', 'reportRows'));
    }

    public function salesPrint(Request $request): View
    {
        $orders = $this->pickedUpOrdersQuery($request)->get();

        $totalTransactions = $orders->count();
        $totalRevenue = $orders->sum('total_amount');
        $reportRows = $this->buildSalesReportRows($orders);

        return view('admin.reports.sales-print', compact('totalTransactions', 'totalRevenue', 'reportRows'));
    }

    private function pickedUpOrdersQuery(Request $request)
    {
        $query = Order::with(['user', 'orderItems.product'])
            ->where('status', 'picked_up')
            ->orderBy('picked_up_at');

        if ($request->filled('date_from')) {
            $query->whereDate('picked_up_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('picked_up_at', '<=', $request->date_to);
        }

        return $query;
    }

    /**
     * @param  Collection<int, Order>  $orders
     * @return Collection<int, object{
     *     no: int,
     *     order_code: string,
     *     customer_name: string,
     *     customer_email: string,
     *     product_name: string,
     *     qty: int,
     *     item_subtotal: string|float|int,
     *     picked_up_at: \Illuminate\Support\Carbon|null
     * }>
     */
    private function buildSalesReportRows(Collection $orders): Collection
    {
        $rows = collect();
        $no = 1;

        foreach ($orders as $order) {
            if ($order->orderItems->isEmpty()) {
                $rows->push((object) [
                    'no' => $no++,
                    'order_code' => $order->order_code,
                    'customer_name' => $order->user->name,
                    'customer_email' => $order->user->email,
                    'product_name' => '-',
                    'qty' => 0,
                    'item_subtotal' => 0,
                    'picked_up_at' => $order->picked_up_at,
                ]);

                continue;
            }

            foreach ($order->orderItems as $item) {
                $rows->push((object) [
                    'no' => $no++,
                    'order_code' => $order->order_code,
                    'customer_name' => $order->user->name,
                    'customer_email' => $order->user->email,
                    'product_name' => $item->product->name ?? '-',
                    'qty' => $item->qty,
                    'item_subtotal' => $item->subtotal,
                    'picked_up_at' => $order->picked_up_at,
                ]);
            }
        }

        return $rows;
    }
}
