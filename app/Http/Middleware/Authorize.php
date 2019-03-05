<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Route;

class Authorize
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
		$except_route = array('logout', 'login', 'api.create', 'change-level', 'change-semester', '/');
		//dd(Route::getRoutes()->match($request)->getName());
		if(Auth::guest()){
				redirect(route('login'));
		}else{
			if(!in_array(Route::getRoutes()->match($request)->getName(), $except_route)){
				$route = Route::getRoutes()->match($request)->getName();
				$id_level = session('id_level');//Ambil dari session
				$access = BaseController::getAccess($id_level, $route);
				//dd($access);
				if($access == false){
					abort("404", "This Content is not available on Your Country!");
				}
			}
		}

        return $next($request);
    }
}
