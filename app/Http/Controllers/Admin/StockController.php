<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StockMovementRequest;
use App\Models\Product;
use App\Models\StockMovement;
use App\Services\StockService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StockController extends Controller
{
    public function __construct(
        private StockService $stockService,
    ) {}

    public function index(): View
    {
        $products = Product::orderBy('name')->get();

        $recentMovements = StockMovement::with(['product', 'admin'])
            ->latest()
            ->limit(20)
            ->get();

        return view('admin.stocks.index', compact('products', 'recentMovements'));
    }

    public function store(StockMovementRequest $request): RedirectResponse
    {
        $product = Product::findOrFail($request->validated('product_id'));

        try {
            $this->stockService->processMovement(
                product: $product,
                type: $request->validated('type'),
                qty: (int) $request->validated('qty'),
                note: $request->validated('note'),
                adminId: auth()->id(),
            );
        } catch (\InvalidArgumentException $e) {
            return redirect()->route('admin.stocks.index')
                ->with('error', $e->getMessage())
                ->withInput();
        }

        $typeLabel = match ($request->validated('type')) {
            'in'     => 'Stock In',
            'out'    => 'Stock Out',
            'adjust' => 'Stock Adjust',
        };

        return redirect()->route('admin.stocks.index')
            ->with('success', "{$typeLabel} for \"{$product->name}\" processed successfully. Current stock: {$product->fresh()->stock}.");
    }

    public function history(Request $request): View
    {
        $query = StockMovement::with(['product', 'admin', 'order']);

        if ($productId = $request->input('product_id')) {
            $query->where('product_id', $productId);
        }

        if ($dateFrom = $request->input('date_from')) {
            $query->whereDate('created_at', '>=', $dateFrom);
        }

        if ($dateTo = $request->input('date_to')) {
            $query->whereDate('created_at', '<=', $dateTo);
        }

        $movements = $query->latest()
            ->paginate(20)
            ->appends($request->only(['product_id', 'date_from', 'date_to']));

        $products = Product::orderBy('name')->get();

        return view('admin.stocks.history', compact('movements', 'products'));
    }
}
