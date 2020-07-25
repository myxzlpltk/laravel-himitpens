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
		<div class="row">
			@forelse($posts as $post)
			<div class="col-md-4 d-flex align-items-stretch">
				<div class="card mb-4 box-shadow">
					<img class="card-img-top" src="{{ Storage::disk('public')->url('posts/'.$post->photo) }}" alt="Card image cap">
					<div class="card-body">
						<small>{{ is_null($post->published_at) ? 'Draf' :$post->published_at->format('d F Y') }} | {{ $post->user->name }}</small>
						<h5 class="card-title">
							<a href="">{{ $post->title }}</a>
						</h5>
						<p class="card-text">{{ $post->excerpt }}</p>
					</div>
					<div class="card-footer bg-white d-flex justify-content-between align-items-center">
						<div class="btn-group">
							<a href="{{ route('posts.publish', $post->id) }}" class="card-link" onclick="return window.confirm('Kamu akan mempublis artikel ini. Apakah anda yakin?')">Publis</a>
							<a href="{{ route('posts.edit', $post->id) }}" class="card-link">Edit</a>
							<a href="{{ route('posts.delete', $post->id) }}" class="card-link" onclick="return window.confirm('Kamu akan menghapus artikel ini. Apakah anda yakin?')">Hapus</a>
						</div>
						<small class="text-muted"></small>
					</div>
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
