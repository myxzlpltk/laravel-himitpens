<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Post extends Model{

	protected $casts = [
		'published_at' => 'datetime:Y-m-d H:i'
	];

	protected static function boot(){
		parent::boot();

		static::creating(function($post){
			$post->slug = Str::slug($post->title);
		});

		static::updating(function($post){
			if($post->isDirty('title')){
				$post->slug = Str::slug($post->title);
			}
		});
	}

	public function user(){
		return $this->belongsTo('App\User');
	}

	public function getExcerptAttribute(){
		return Str::words(strip_tags($this->content), 25, '...');
	}
}
