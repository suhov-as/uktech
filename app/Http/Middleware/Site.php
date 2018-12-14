<?php
namespace App\Http\Middleware;

use Closure;
use Session;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;

class Site
{
	/**
	 * SiteMiddleware constructor.
	 *
	 * @param Guard   $auth
	 * @param Request $request
	 */
	public function __construct(Guard $auth, Request $request)
	{
	}
    protected $except;
    protected function shouldIgnore($request)
    {
        $this->except = $this->except ?? config('laravellocalization.urlsIgnored', []);
        foreach ($this->except as $except) {
            if ($except !== '/') {
                $except = trim($except, '/');
            }

            if ($request->is($except)) {
                return true;
            }
        }

        return false;
    }

	/**
	 * @param         $request
	 * @param Closure $next
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function handle($request, Closure $next)
	{
        if ($this->shouldIgnore($request)) {
            return $next($request);
        }

        $params = explode('/', $request->path());
        $locale = session('locale', false);

        if (\count($params) > 0 && app('laravellocalization')->checkLocaleInSupportedLocales($params[0])) {
            session(['locale' => $params[0]]);
            session(['lang' => $params[0]]);

            return $next($request);
        }
		$setLocale = \Request::input('setLang');
		$redirect  = \Request::input('redirect') ?? false;

		if($setLocale) {
			Session::put('lang', $locale);

          if($redirect)
            return redirect($redirect);
          else
            return redirect()->back();
		}

		if(Session::get('lang') === null) {
			Session::put('lang', session('locale'));
		}

		\App::setLocale(session('locale'));

		return $next($request);
	}
}