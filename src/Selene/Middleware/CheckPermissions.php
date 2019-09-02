<?php

namespace Selene\Middleware;

use Closure;
use Request;
use Illuminate\Support\Facades\Gate;

/**
 * Class CheckPermissions
 * @package Selene\Middleware
 */
class CheckPermissions
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @param $anchor
     * @param bool $redirectBack
     *
     * @return mixed
     */
    public function handle($request, Closure $next, $anchor, $redirectBack = false)
    {

        if (!Gate::allows($anchor)) {
            if(Request::url() === url()->previous()) {
                return redirect('/');
            }

            if ($redirectBack) return redirect()->back();

            return redirect('/');
        }

        return $next($request);
    }
}
