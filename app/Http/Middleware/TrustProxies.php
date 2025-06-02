<?php

namespace App\Http\Middleware;

use Illuminate\Http\Middleware\TrustProxies as Middleware;
use Illuminate\Http\Request;

class TrustProxies extends Middleware
{
    /**
     * The trusted proxies for this application.
     *
     * Gunakan '*' untuk mempercayai semua proxy seperti Caddy/Nginx.
     */
    protected array|string|null $proxies = '*';

    /**
     * Headers yang digunakan Laravel untuk mendeteksi informasi asli request.
     */
    protected int $headers = Request::HEADER_X_FORWARDED_ALL;
}
