<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RegionLock
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (get_client_ip() != "UNKNOWN") {
            if (ip_info(get_client_ip())["country"] != "Indonesia") {
                die("<h1>Maaf. Layanan ini hanya tersedia di negara indonesia</h1><br><p>Kalau anda orang indonessia liat tulisan ini pasti pake VPN mau pekalongan ya kan? keciduk deh</p>");    
            }
        }
        return $next($request);
    }
}
