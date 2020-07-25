<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class Post extends Model{

	protected $casts = [
		'published_at' => 'datetime:Y-m-d H:i'
	];

	protected static function boot(){
		parent::boot();

		static::creating(function($post){
			$post->slug = Str::slug($post->title);

			$image = Image::make(Storage::disk('public')->get('posts/'.$post->photo));
			$image->resize(300, 300, function($constraint){
				$constraint->aspectRatio();
				$constraint->upsize();
			});
			Storage::disk('public')->put('posts/thumbs/'.$post->photo, $image->encode('jpg', 80));
		});

		static::updating(function($post){
			if($post->isDirty('title')){
				$post->slug = Str::slug($post->title);
			}

			if($post->isDirty('photo')){
				Storage::disk('public')->delete('posts/'.$post->getOriginal('photo'));
				Storage::disk('public')->delete('posts/thumbs/'.$post->getOriginal('photo'));

				$image = Image::make(Storage::disk('public')->get('posts/'.$post->photo));
				$image->resize(300, 300, function($constraint){
					$constraint->aspectRatio();
					$constraint->upsize();
				});
				Storage::disk('public')->put('posts/thumbs/'.$post->photo, $image->encode('jpg', 80));
			}
		});

		static::deleting(function($post){
			Storage::disk('public')->delete('posts/'.$post->getOriginal('photo'));
			Storage::disk('public')->delete('posts/thumbs/'.$post->getOriginal('photo'));
		});
	}

	public function user(){
		return $this->belongsTo('App\User');
	}

	public function getExcerptAttribute(){
		return Str::words(strip_tags($this->content), 25, '...');
	}
}
