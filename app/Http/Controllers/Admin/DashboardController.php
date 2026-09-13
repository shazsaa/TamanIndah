<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $totalActiveProducts = Product::where('is_active', true)->count();
        $ordersPendingPayment = Order::whereIn('status', ['pending_payment', 'payment_submitted'])->count();
        $ordersConfirmed = Order::where('status', 'confirmed')->count();
        $ordersPickedUpThisMonth = Order::where('status', 'picked_up')
            ->whereMonth('picked_up_at', Carbon::now()->month)
            ->whereYear('picked_up_at', Carbon::now()->year)
            ->count();

        $lowStockProducts = Product::with('category')
            ->where('is_active', true)
            ->where('stock', '<', 5)
            ->orderBy('stock', 'asc')
            ->get();

        // Tren Penjualan 7 hari terakhir
        $trenPenjualan = collect(range(6, 0))->map(function ($daysAgo) {
            $date = Carbon::now()->subDays($daysAgo);
            $total = Order::whereIn('status', ['confirmed', 'picked_up'])
                ->whereDate('created_at', $date)
                ->sum('total_amount');
            return [
                'label' => $date->translatedFormat('D'),
                'value' => (float) $total,
            ];
        });

        // Status Pesanan
        $statusPesanan = [
            'Menunggu Pembayaran' => Order::whereIn('status', ['pending_payment', 'payment_submitted'])->count(),
            'Dikonfirmasi'        => Order::where('status', 'confirmed')->count(),
            'Selesai'             => Order::where('status', 'picked_up')->count(),
            'Dibatalkan'          => Order::where('status', 'cancelled')->count(),
        ];

        // Top 5 Produk Terlaris
        $topProduk = DB::table('order_items')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->select('products.name', DB::raw('SUM(order_items.qty) as total_qty'))
            ->groupBy('products.id', 'products.name')
            ->orderByDesc('total_qty')
            ->limit(5)
            ->get();

        // Pendapatan Bulanan 6 bulan terakhir
        $pendapatanBulanan = collect(range(5, 0))->map(function ($monthsAgo) {
            $date = Carbon::now()->subMonths($monthsAgo);
            $total = Order::whereIn('status', ['confirmed', 'picked_up'])
                ->whereMonth('created_at', $date->month)
                ->whereYear('created_at', $date->year)
                ->sum('total_amount');
            return [
                'label' => $date->format('M'),
                'value' => (float) $total,
            ];
        });

        // Review Pembayaran Harian 5 hari terakhir
        $pembayaranHarian = collect(range(4, 0))->map(function ($daysAgo) {
            $date = Carbon::now()->subDays($daysAgo);
            return [
                'label'   => $date->translatedFormat('D'),
                'pending' => DB::table('payments')
                    ->where('status', 'submitted')
                    ->whereDate('submitted_at', $date)
                    ->count(),
            ];
        });

        return view('admin.dashboard', compact(
            'totalActiveProducts',
            'ordersPendingPayment',
            'ordersConfirmed',
            'ordersPickedUpThisMonth',
            'lowStockProducts',
            'trenPenjualan',
            'statusPesanan',
            'topProduk',
            'pendapatanBulanan',
            'pembayaranHarian',
        ));
    }
}
