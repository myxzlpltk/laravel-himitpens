@extends('layouts.app')

@section('title', 'Beranda')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-9 mx-auto">
			@if(Auth::check())
			<div class="actions my-4">
				@can('publish', $post)
				<a href="{{ route('posts.publish', $post->id) }}" class="btn btn-primary" onclick="return window.confirm('Kamu akan mempublis artikel ini. Apakah anda yakin?')">Publis</a>
				@endcan
				@can('update', $post)
				<a href="{{ route('posts.edit', $post->id) }}" class="btn btn-warning">Edit</a>
				@endcan
				@can('delete', $post)
				<a href="{{ route('posts.delete', $post->id) }}" class="btn btn-danger" onclick="return window.confirm('Kamu akan menghapus artikel ini. Apakah anda yakin?')">Hapus</a>
				@endcan
			</div>
			@endif
		</div>
	</div>

	<h4 class="text-center my-4">{{ $post->title }}</h4>
	<img src="{{ Storage::disk('public')->url('posts/'.$post->photo) }}" class="img-fluid d-block mx-auto my-4" style="max-height: 300px;">

	<div class="row">
		<div class="col-md-9 mx-auto">
			<p class="text-muted">Ditulis oleh {{ $post->user->name }} | {{ is_null($post->published_at) ? 'Draf' :$post->published_at->format('d F Y') }}</p>
			<div class="content">
				{!! $post->content !!}
			</div>
		</div>
	</div>

</div>
@endsection
