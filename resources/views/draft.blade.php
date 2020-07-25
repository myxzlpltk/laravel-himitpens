@extends('layouts.app')

@section('title', 'Draf artikel')

@section('content')
@if (session('status'))
	<div class="alert alert-success mb-4" role="alert">
		{{ session('status') }}
	</div>
@endif
<section class="text-center">
	<div class="container">
		<h1 class="jumbotron-heading">{{ Auth::user()->name }}</h1>
		<p class="lead text-muted">Kamu sedang dalam mode admin. Kamu berhak untuk mengelola semua artikel disini.</p>
		<a href="{{ route('home') }}" class="btn btn-secondary my-2">Kembali</a>
	</div>
</section>
<div class="album py-5 bg-light">
	<div class="container">
		<div class="row justify-content-center">
			@forelse($posts as $post)
			<div class="col-lg-3 col-md-4 col-sm-6 d-flex align-items-stretch">
				<div class="card mb-4 box-shadow post w-100">
					<div class="embed-responsive embed-responsive-16by9">
						<img class="card-img-top embed-responsive-item" src="{{ Storage::disk('public')->url('posts/thumbs/'.$post->photo) }}" alt="Thumbnail">
					</div>
					<div class="card-body">
						<small>{{ is_null($post->published_at) ? 'Draf' :$post->published_at->format('d F Y') }} | {{ $post->user->name }}</small>
						<h5 class="card-title">
							<a href="{{ route('posts.view', $post->slug) }}">{{ $post->title }}</a>
						</h5>
						<p class="card-text">{{ $post->excerpt }}</p>
					</div>
					@can('belong', $post)
					<div class="card-footer bg-white d-flex justify-content-between align-items-center">
						<div class="btn-group">
							@can('publish', $post)
							<a href="{{ route('posts.publish', $post->id) }}" class="card-link" onclick="return window.confirm('Kamu akan mempublis artikel ini. Apakah anda yakin?')">Publis</a>
							@endcan
							@can('update', $post)
							<a href="{{ route('posts.edit', $post->id) }}" class="card-link">Edit</a>
							@endcan
							@can('delete', $post)
							<a href="{{ route('posts.delete', $post->id) }}" class="card-link" onclick="return window.confirm('Kamu akan menghapus artikel ini. Apakah anda yakin?')">Hapus</a>
							@endcan
						</div>
						<small class="text-muted"></small>
					</div>
					@endcan
				</div>
			</div>
			@empty
			<div class="col-12">
				<p class="text-center text-muted lead">Tidak ada artikel</p>
			</div>
			@endforelse
		</div>
	
		{{ $posts->links() }}
	</div>
</div>
@endsection
