<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;

class PostController extends Controller{

	public function Index(){
		$posts = Post::with('user')
			->whereNotNull('published_at')
			->orderByDesc('published_at')
			->paginate(3);

		return view('home', ['posts' => $posts]);
	}

	public function Draft(){
		$posts = Post::with('user')
			->whereNull('published_at')
			->orderByDesc('created_at')
			->paginate(3);

		return view('draft', ['posts' => $posts]);
	}

	public function Publish(Request $request, $id){
		$post = Post::whereNull('published_at')->findOrFail($id);

		$post->published_at = now();
		$post->update();

		return redirect()->route('posts.view', $post->slug)->with(['status' => 'Berita berhasil dipublis.']);
	}

	public function View(Request $request, $id){
	}

	public function Create(Request $request, $id){
	}

	public function Edit(Request $request, $id){
	}

	public function Delete(Request $request, $id){
	}
	
}
