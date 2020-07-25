@extends('layouts.app')

@section('title', 'Beranda')

@section('content')
<div class="container">
	<div class="card">
		<div class="card-body">
			<form action="{{ route('posts.store') }}" method="post" enctype="multipart/form-data">
				@csrf
				<div class="form-group">
					<img src="" id="image-preview" class="img-fluid d-block mx-auto mb-3" style="max-height: 300px;">
					<label for="foto">Sampul Artikel</label>
					<div class="custom-file">
						<input type="file" name="foto" id="foto" accept=".jpg,.jpeg,.png" class="custom-file-input @error('foto') is-invalid @enderror" onchange="previewImage()" required="">
						<label for="foto" class="custom-file-label">Pilih Foto</label>
					</div>
					@error('foto')
					<span class="invalid-feedback d-block" role="alert">
						<strong>{{ $message }}</strong>
					</span>
					@enderror
				</div>
				<div class="form-group">
					<label for="title">Judul</label>
					<input type="text" name="title" id="title" class="form-control @error('foto') is-invalid @enderror" value="{{ old('title') }}" required="">
					@error('title')
					<span class="invalid-feedback d-block" role="alert">
						<strong>{{ $message }}</strong>
					</span>
					@enderror
				</div>
				<div class="form-group">
					<label for="content">Judul</label>
					<textarea name="content" id="content" class="form-control @error('foto') is-invalid @enderror" required="">{{ old('content') }}</textarea>
					@error('content')
					<span class="invalid-feedback d-block" role="alert">
						<strong>{{ $message }}</strong>
					</span>
					@enderror
				</div>
				<button type="submit" name="submit" value="publish" class="btn btn-primary">Simpan</button>
				<button type="submit" name="submit" value="draf" class="btn btn-secondary">Simpan sebagai draf</button>
			</form>
		</div>
	</div>
</div>

<script type="text/javascript" src="{{ asset('vendor/ckeditor/ckeditor.js') }}"></script>
<script type="text/javascript" src="{{ asset('vendor/ckeditor/lang/id.js') }}"></script>
<script>
	function previewImage() {
		document.getElementById("image-preview").style.display = "block";
		var oFReader = new FileReader();
		oFReader.readAsDataURL(document.getElementById("foto").files[0]);

		oFReader.onload = function(oFREvent) {
			document.getElementById("image-preview").src = oFREvent.target.result;
		};
	};

	CKEDITOR.replace('content');
</script>
@endsection
