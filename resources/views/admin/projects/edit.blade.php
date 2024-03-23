@extends('layouts.app')

@section('title', 'Edit Projects')

@section('content')
    <div class="card m-5 p-3 shadow-lg">
        <h1 class="text-center mt-3 text-uppercase text-danger">Modifica progetto</h1>
        <form action="{{ route('admin.projects.update', $project->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-6">
                    <div class="mb-3">
                        <label for="title" class="form-label">Titolo Progetto</label>
                        <input type="text"
                            class="form-control 
                            @error('title') is-invalid 
                            @elseif(old('title')) is-valid 
                            @enderror"
                            id="title" placeholder="Titolo Progetto" name="title" value="{{ old('title', $project->title) }}">
                        @error('title')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="col-5">
                    <div class="mb-3">
                        <label for="slug" class="form-label">Slug</label>
                        <input type="text" class="form-control" id="slug" value="{{ Str::slug(old('title', $project->title)) }}" disabled>
                    </div>
                </div>
                <div class="col-1 mt-5">
                    <div class="mb-3 form-check">
                        <input value="1" type="checkbox" class="form-check-input" id="is_published" name="is_published" @if (old('is_published', $project->is_published))
                            checked
                        @endif>
                        <label for="is_published" class="form-check-label">Pubblica</label>
                    </div>
                </div>
                <div class="col-12">
                    <div class="mb-3">
                        <label for="content" class="form-label">Descrizione Progetto</label>
                        <textarea class="form-control @error('content') is-invalid 
                        @elseif(old('content')) is-valid 
                        @enderror" name="content" id="content" rows="10">{{ old('content', $project->content) }}</textarea>
                        @error('content')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="col-11">
                    <div class="mb-3">
                        <label for="image" class="form-label">Immagine Progetto</label>
                        <input type="url"
                            class="form-control 
                            @error('image') is-invalid 
                            @elseif(old('image')) is-valid 
                            @enderror"
                            id="image" placeholder="Http.// O https://" name="image" value="{{ old('image', $project->image) }}">
                        @error('image')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="col-1">
                    <div class="mb-5">
                        <img src="{{ old('image', $project->image ?? 'https://marcolanci.it/boolean/assets/placeholder.png') }}"
                            class="img-fluid" alt="Immageni Progetto" id="preview">
                    </div>
                </div>
                <div class="col-6">
                    <div class="d-flex justify-content-start align-items-center">
                        <a class="btn btn-secondary" href="{{ route('admin.projects.index') }}"><i class="fa-solid fa-rotate-left me-2"></i>Torna Indietro</a>
                    </div>
                </div>
                <div class="col-6">
                    <div class="d-flex justify-content-end align-items-center gap-3">
                        <button type="submit" class="btn btn-info"><i class="fas fa-eraser me-2"></i>Svuota campi</button>
                        <button type="submit" class="btn btn-success"><i class="fas fa-floppy-disk me-2"></i>Salva
                            Progetto</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('js')
    {{-- PREVIEW IMMAGINE --}}
    @vite('resources/js/preview_img.js')
    {{-- SLUG TITOLO --}}
    @vite('resources/js/slug.js')
@endsection