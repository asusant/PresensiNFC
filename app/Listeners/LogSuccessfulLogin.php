<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Http\Controllers\BaseController;

class LogSuccessfulLogin
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  Login  $event
     * @return void
     */
    public function handle(Login $event)
    {
        $id_user = $event->user['id'] ;
		// $level = BaseController::getLevelsByIdUser($id_user);
		// $level_terendah = end($level)->id_level;
        // 
		$level = BaseController::getHighestLevelsByIdUser($id_user); // Level Tertinggi
        $semester = BaseController::getLastSemester();
        // dd($level);
        session(['id_level' => $level->id_level, 'id_semester' => $semester->id]);

    }
}
