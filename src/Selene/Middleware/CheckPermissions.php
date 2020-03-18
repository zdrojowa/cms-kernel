<?php

namespace Selene\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Request;
use Illuminate\Support\Facades\Gate;
use Selene\Support\Config\Config;
use Selene\Support\Enums\Core\Core as CoreEnum;

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
        if (Config::get(CoreEnum::IS_DEV)) {
            Auth::loginUsingId(1);
        }

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
