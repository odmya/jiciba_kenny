<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

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
    //  $wechatuser = session('wechatuser');

      $user = session('wechat.oauth_user');

      if ($user ==false) {
        return redirect()->route('wechatoauth');
      }

      return $next($request);

    }
}
