<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApplyDemoBasePath
{
    /**
     * Apply the configured external prefix to requests proxied by the local
     * gateway. This keeps the application prefix configuration authoritative
     * instead of accepting a different forwarded prefix.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $basePath = config('demo.base_path');

        if ($basePath !== '' && $basePath !== '/' && in_array($request->server->get('REMOTE_ADDR'), ['127.0.0.1', '::1'], true)) {
            $request->headers->set('X-Forwarded-Prefix', $basePath);
            $request->setBaseUrl($basePath);
        }

        return $next($request);
    }
}
