<?php

namespace App\Http\Helpers;

class Format
{
	public static $lokasi = 'Jakarta';

	public static function convertNilai($nilai)
	{
		$index = 'E';
		if ($nilai > 49) {
			$index = 'D';
		}

		if ($nilai > 59) {
			$index = 'C';
		}

		if ($nilai > 69) {
			$index = 'B';
		}

		if ($nilai > 79) {
			$index = 'A';
		}

		return $index;
	}
}