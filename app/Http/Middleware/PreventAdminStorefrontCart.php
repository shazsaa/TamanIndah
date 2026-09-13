<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PreventAdminStorefrontCart
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (! $user || ! $user->isAdmin()) {
            return $next($request);
        }

        return match ($request->route()?->getName()) {
            'cart.index', 'checkout.index', 'checkout.success' => redirect()->route('admin.dashboard'),
            'cart.add', 'cart.update', 'cart.remove' => back()->with('error', 'Admin cannot place orders.'),
            'checkout.store' => redirect()->route('admin.dashboard')->with('error', 'Admin cannot place orders.'),
            default => $next($request),
        };
    }
}
