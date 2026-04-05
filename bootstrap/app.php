<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
         $middleware->alias([
            'role' => \App\Http\Middleware\CheckRole::class,
    ]);

    
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (App\Exceptions\RoleAuthorizationException $e, $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Access denied',
                    'error' => 'INSUFFICIENT_PERMISSIONS',
                    'required_role' => $e->getRequiredRole()
                ], 403);
            }

            abort(403, 'Anda tidak memiliki akses ke halaman ini. Role yang diperlukan: ' . $e->getRequiredRole());
        });

        $exceptions->render(function (App\Exceptions\PaymentException $e, $request) {
            \Log::error('Payment Exception: ' . $e->getMessage(), [
                'errors' => $e->getErrors(),
                'trace' => $e->getTraceAsString()
            ]);

            if ($request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Payment processing failed',
                    'error' => 'PAYMENT_ERROR'
                ], 422);
            }

            return back()->withErrors(['payment' => 'Pembayaran gagal diproses. Silakan coba lagi.']);
        });

        $exceptions->render(function (App\Exceptions\TransactionException $e, $request) {
            \Log::error('Transaction Exception: ' . $e->getMessage(), [
                'transaction_id' => $e->getTransactionId(),
                'trace' => $e->getTraceAsString()
            ]);

            if ($request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Transaction processing failed',
                    'error' => 'TRANSACTION_ERROR'
                ], 422);
            }

            return back()->withErrors(['transaction' => 'Transaksi gagal diproses. Silakan coba lagi.']);
        });
    })->create();
    
