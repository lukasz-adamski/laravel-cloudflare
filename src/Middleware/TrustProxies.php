<?php

namespace Adams\Cloudflare\Middleware;

use Cache;
use Illuminate\Http\Request;

class TrustProxies 
{
	/**
	 * Handle an incoming request.
	 *
	 * @param Request $request
	 * @param \Closure $next
	 * @return mixed
	 */
	public function handle(Request $request, \Closure $next)
	{
		$proxies = Cache::get('cloudflare.proxies');

		if (! is_null($proxies)) {
			$request->setTrustedProxies($proxies);
		}
        
		return $next($request);
	}
}