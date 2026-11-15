<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RequireAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->session()->get('admin_authenticated') !== true) {
            return response('Silakan masuk kembali ke admin.', 401);
        }

        $admin = User::query()->whereKey($request->session()->get('admin_user_id'))->where('is_admin', true)
            ->where('is_active', true)->first();
        if (! $admin || $admin->village_slug !== $request->session()->get('admin_village_slug')) {
            $request->session()->invalidate();

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
