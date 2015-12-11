<?php namespace App\Http\Middleware;

use App\User;
use Closure;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class UserAuth {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
    public function handle($request, Closure $next)
    {
        if(Session::get('userid')==""){return Redirect::to('login');}
        if(Session::get('username')==""){return Redirect::to('login');}
        $UserInfo=User::find(Session::get('userid'));
        if(Session::get('username')!=$UserInfo->name){return Redirect::to('login');}
        return $next($request);
    }

}
