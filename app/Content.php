<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Content extends Model
{
		use SoftDeletes;

		protected $dates = ['deleted_at'];
    	protected $table = 'contents';
  		protected $fillable = ['*'];

  		public static function content($key)
  		{
  			$data = Content::where('section', $key)->first();
			$count = Content::where('section', $key)->count();
			if ($count == 0) {
				return "";
			}else{
				return $data->content;
			}
  		}
}
