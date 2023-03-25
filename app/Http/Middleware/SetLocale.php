<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Session;

class SetLocale
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
        $locale = \Session::get('locale', App::currentLocale());

        $requestLocale = $request->segment(1);

        if (in_array($requestLocale, config('app.available_locales'), strict: true)) {
            $locale = $requestLocale;
        } else {
            return redirect($locale);
        }

        App::setLocale($locale);
        URL::defaults(['locale' => $locale]);
        Session::put('locale', $locale);

        return $next($request);
    }
}
