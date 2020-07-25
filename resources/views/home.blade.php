@extends('layouts.app')

@section('title', 'Beranda')

@section('content')
@if(Auth::check())
<section class="text-center">
	<div class="container">
		<h1 class="jumbotron-heading">{{ Auth::user()->name }}</h1>
		<p class="lead text-muted">Kamu sedang dalam mode admin. Kamu berhak untuk mengelola semua artikel disini.</p>
		<div>
			<a href="{{ route('posts.create') }}" class="btn btn-primary my-2">Buat artikel baru</a>
			<a href="{{ route('posts.draft') }}" class="btn btn-secondary my-2">Draf</a>
		</div>
	</div>
</section>
@endif
<div class="album py-5 bg-light">
	<div class="container">
		<div class="row">
			@forelse($posts as $post)
			<div class="col-md-4 d-flex align-items-stretch">
				<div class="card mb-4 box-shadow post">
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
