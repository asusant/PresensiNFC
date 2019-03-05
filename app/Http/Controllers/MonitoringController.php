<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Monitoring\Models\Monitoring;
use Reyzeal\Fuzzy;
use DB;

class MonitoringController extends Controller
{
	public function inputMonitoring($suhu, $ph, Request $request)
	{
		$data['suhu'] = $suhu;
		$data['ph'] = $ph;
		$data['ip'] = $request->ip();
		$data['user_agent'] = $request->header('User-Agent');

		$fuzzy = new Fuzzy('Penentuan Kondisi Kolam', 'Tsukamoto');

		$fuzzy->input()
				->addCategory('Suhu')
				->addMembership('Dingin', 'trapmf', [20,20,28])
				->addMembership('Normal', 'trapmf', [20,28,30,35])
				->addMembership('Panas', 'trapmf', [30,35,35]);

		$fuzzy->input()
				->addCategory('pH')
				->addMembership('Asam', 'trapmf', [4,4,5,6.5])
				->addMembership('Optimal', 'trapmf', [5,6.5,7.5,8.5])
				->addMembership('Basa', 'trapmf', [7.5,8.5,11,11]);

		$fuzzy->output()
				->addCategory('Kondisi')
				->addMembership('Kurang', 'trapmf', [0,0,10])
				->addMembership('Stabil', 'trapmf', [0,10,12,13])
				->addMembership('Buruk', 'trapmf', [12,15,15,15]);

		$fuzzy->rules()->add('Suhu_Dingin AND pH_Asam')->then('Kondisi_Buruk');
		$fuzzy->rules()->add('Suhu_Normal AND pH_Asam')->then('Kondisi_Kurang');
		$fuzzy->rules()->add('Suhu_Panas AND pH_Asam')->then('Kondisi_Buruk');

		$fuzzy->rules()->add('Suhu_Dingin AND pH_Optimal')->then('Kondisi_Kurang');
		$fuzzy->rules()->add('Suhu_Normal AND pH_Optimal')->then('Kondisi_Stabil');
		$fuzzy->rules()->add('Suhu_Panas AND pH_Optimal')->then('Kondisi_Kurang');

		$fuzzy->rules()->add('Suhu_Dingin AND pH_Basa')->then('Kondisi_Buruk');
		$fuzzy->rules()->add('Suhu_Normal AND pH_Basa')->then('Kondisi_Kurang');
		$fuzzy->rules()->add('Suhu_Panas AND pH_Basa')->then('Kondisi_Buruk');

		echo $fuzzy->calc([
			'Suhu' => $data['suhu'],
			'pH' => $data['ph']
		]);

		die();
	}

}