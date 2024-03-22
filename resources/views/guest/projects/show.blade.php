@extends('layouts.app')

@section('title', 'Project')

@section('content')
<div class="container">
    <header>
        <h1 class="text-center my-3 text-uppercase text-danger">{{ $project->title }}</h1>
    </header>
    <div class="card p-3">
        <div class="clearfix">
            @if ($project->image)
                <img src="{{ $project->image }}" alt="{{ $project->title }}" class="me-3 float-start mt-1">
            @endif
            <p>{{ $project->content }}</p>
            <div class="d-flex align-items-center text-uppercase gap-1">
                <strong>Data creazione: </strong> <span class="me-3">{{ $project->getCreatedAt() }}</span>
                <strong>Ultima modifica: </strong> <span>{{ $project->getUpdatedAt() }}</span>
            </div>
        </div>
        <footer class="d-flex justify-content-between align-items-center mt-5">
            <a href="{{ route('guest.projects.index') }}" class="btn btn-secondary">
                <i class="fa-solid fa-rotate-left me-2"></i>
                Torna indietro
            </a>
        </footer>
    </div>
</div>
@endsection