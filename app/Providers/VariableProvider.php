<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Auth;

class VariableProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {

		view()->composer('*', function ($view)
	    {
			$menu = BaseController::getMenuAsLevel(session('id_level'));
            $levels = BaseController::getLevelsNameByIdUser(Auth::id());
            $semester = BaseController::getSemester();
			$semesterAktif = BaseController::getSemesterAktif();
	        $view->with('menus', $menu);
            $view->with('levels', $levels);
            $view->with('semester', $semester);
	        $view->with('semesterAktif', $semesterAktif);
	    });


        // View::share('menus', $menu);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
