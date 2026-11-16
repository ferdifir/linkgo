<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class RequireAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        $admin = $request->user();

        if (! $admin || ! $admin->is_admin || ! $admin->is_active || ! $admin->village_slug) {
            return response('Silakan masuk kembali ke admin.', 401);
        }

        if (! DB::table('village_pages')->where('slug', $admin->village_slug)->exists()) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return response('Silakan masuk kembali ke admin.', 401);
        }

        if (! $this->sameOrigin($request)) {
            return response('Sumber permintaan tidak valid.', 403);
        }

        return $next($request);
    }

    private function sameOrigin(Request $request): bool
    {
        if ($request->isMethod('GET') || $request->isMethod('HEAD')) {
            return true;
        }

        $origin = $request->header('Origin') ?: $request->header('Referer');
        if (! $origin) {
            return false;
        }

        $scheme = strtolower((string) parse_url($origin, PHP_URL_SCHEME));
        $originPort = parse_url($origin, PHP_URL_PORT) ?? ($scheme === 'https' ? 443 : 80);

        return strtolower((string) parse_url($origin, PHP_URL_HOST)) === strtolower($request->getHost())
            && $originPort === $request->getPort()
            && $scheme === $request->getScheme();
    }
}
