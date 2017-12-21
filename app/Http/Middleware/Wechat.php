<?php

namespace App\Http\Middleware;

use Closure;

class Wechat
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
      if (empty($_SESSION['wechat.oauth_user'])) {
        return redirect()->route('wechatoauth');
      }

    }
}
