@extends('layouts.app')

@section('title', 'Projects List Admin')

@section('content')
    <div class="container">
        <header class="d-flex justify-content-between align-items-center">
            <h1 class="mt-4 text-uppercase text-danger">Lista Progetti</h1>
            <div class="d-flex justify-content-center align-items-center gap-3 mt-4">
                {{-- Filtro --}}
                <form action="{{ route('admin.projects.index') }}" method="GET">
                    <div class="input-group">
                        <select name="filter" class="form-select">
                            <option value="">Tutti</option>
                            <option @if ($filter === 'published') selected @endif value="published">Completati</option>
                            <option @if ($filter === 'draft') selected @endif value="draft">Bozze</option>
                        </select>
                        <button class="btn btn-dark text-warning" type="submit">Filtra</button>
                    </div>
                </form>
                <a href="{{ route('admin.projects.trash') }}" class="btn btn-secondary">Vedi Cestino<i
                        class="far fa-trash-can ms-2"></i></a>
            </div>
        </header>
        <div class="card p-3 shadow-lg mt-3">
            <table class="table table-dark table-striped table-hover mt-4">
                <thead>
                    <tr class="text-uppercase">
                        <th class="text-warning" scope="col">#</th>
                        <th class="text-warning" scope="col">Titolo</th>
                        <th class="text-warning" scope="col">Slug</th>
                        <th class="text-warning" scope="col">Pubblicato</th>
                        <th class="text-warning" scope="col">Data creazione</th>
                        <th class="text-warning" scope="col">Ultima modifica</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($projects as $project)
                        <tr>
                            <th scope="row">{{ $project->id }}</th>
                            <td>{{ $project->title }}</td>
                            <td>{{ $project->slug }}</td>
                            <td>
                                <form action="{{ route('admin.projects.switch', $project->id) }}" method="POST" onclick="this.submit()">
                                    @csrf 
                                    @method('PATCH')
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" role="button"
                                            id="{{ 'is_published' .$project->id }}" @if ($project->is_published)
                                                checked
                                            @endif>
                                        <label class="form-check-label" for="{{ 'is_published' .$project->id }}">{{ $project->is_published ? 'SI' : 'NO' }}</label>
                                    </div>
                                </form>
                            </td>
                            <td>{{ $project->getCreatedAt() }}</td>
                            <td>{{ $project->getUpdatedAt() }}</td>
                            <td>
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('admin.projects.create') }}" class="btn btn-sm btn-success">
                                        <i class="fas fa-plus"></i>
                                    </a>
                                    <a href="{{ route('admin.projects.show', $project->id) }}"
                                        class="btn btn-sm btn-primary">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.projects.edit', $project->id) }}"
                                        class="btn btn-sm btn-warning">
                                        <i class="fas fa-pencil"></i>
                                    </a>
                                    <form action="{{ route('admin.projects.destroy', $project->id) }}" method="post"
                                        class="trash-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="far fa-trash-can"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">
                                <h3>Non ci sono progetti al momento</h3>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            @if ($projects->hasPages())
                {{ $projects->links() }}
            @endif
        </div>
    </div>
@endsection

@section('js')
    {{-- TOAST --}}
    @vite('resources/js/toast.js')
@endsection
