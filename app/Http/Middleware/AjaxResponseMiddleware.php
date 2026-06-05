<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AjaxResponseMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        if (! $request->ajax()) {
            return $response;
        }

        if ($response instanceof RedirectResponse) {
            $session = $response->getSession();
            $success = $session?->get('success');
            $error = $session?->get('error');

            return response()->json([
                'success' => ! $error,
                'message' => $success ?? $error ?? 'Proses selesai',
                'redirect' => $response->getTargetUrl(),
            ]);
        }

        return $response;
    }
}
