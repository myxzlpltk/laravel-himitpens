<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Mews\Purifier\Facades\Purifier;

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
		$post = Post::findOrFail($id);
		$this->authorize('publish', $post);

		$post->published_at = now();
		$post->update();

		return redirect()->route('posts.view', $post->slug)->with(['status' => 'Berita berhasil dipublis.']);
	}

	public function View(Request $request, $slug){
		if(Auth::check()){
			$post = Post::whereSlug($slug)->firstOrFail();
		}
		else{
			$post = Post::whereNotNull('published_at')->whereSlug($slug)->firstOrFail();
		}

		return view('posts.view', ['post' => $post]);
	}

	public function Create(Request $request){
		$this->authorize('create', Post::class);

		return view('posts.create');
	}

	public function Store(Request $request){
		$this->validate($request, [
			'foto' => 'required|image|max:2048',
			'title' => 'required|string|max:255|unique:App\Post',
			'content' => 'required|string'
		]);

		$foto = Storage::disk('public')->put('posts', $request->file('foto'));

		$post = new Post;
		$post->user_id = $request->user()->id;
		$post->title = trim($request->title);
		$post->content = trim(Purifier::clean($request->content));
		$post->photo = basename($foto);
		$post->published_at = ($request->submit == 'publish' ? now() : NULL);
		$post->save();

		return redirect()->route('posts.view', $post->slug)->with(['status' => 'Berita berhasil diunggah.']);
	}

	public function Edit(Request $request, $id){
		$post = Post::findOrFail($id);
		$this->authorize('update', $post);

		return view('posts.edit', ['post' => $post]);
	}

	public function Update(Request $request, $id){
		$post = Post::findOrFail($id);
		$this->authorize('update', $post);

		$this->validate($request, [
			'foto' => 'nullable|image|max:2048',
			'title' => 'required|string|max:255|unique:App\Post,title,'.$post->id,
			'content' => 'required|string'
		]);

		if($request->file('foto') != NULL){
			$foto = Storage::disk('public')->put('posts', $request->file('foto'));
			$post->photo = basename($foto);
		}

		$post->title = trim($request->title);
		$post->content = trim(Purifier::clean($request->content));
		$post->update();

		return redirect()->route('posts.view', $post->slug)->with(['status' => 'Berita berhasil diperbarui.']);
	}

	public function Delete(Request $request, $id){
		$post = Post::findOrFail($id);
		$this->authorize('delete', $post);

		$post->delete();

		return redirect()->route('home')->with(['status' => 'Berita berhasil dihapus.']);
	}

}
