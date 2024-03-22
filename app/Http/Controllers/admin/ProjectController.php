<?php

namespace App\Http\Controllers\admin;

use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        /* RECUPERI VALORE DELLA QUERY */
        $filter = $request->query('filter');
        
        /* PREPARO LA QUERY DEL MODELLO IN ORDINE DESCRESCENTE MODIFICA E CREAZIONE */
        $query = Project::orderByDesc('updated_at')->orderByDesc('created_at');
        
        /* SE LA VARIABILE FILTER ESISTE ED E' UGUALE A PUBLISHED FILTRIAMO SOLO QUELLI PUBBLICATI */
        if ($filter) {
            $value = $filter === 'published';
            $query->whereIsPublished($value);
        }
        
        /* PAGINAZIONE A 10 ALLA VOLTA E MANTIENI LINK SULL'URL */
        $projects = $query->paginate(10)->withQueryString();

        /* RETURN NELLA STESSA PAGINA */
        return view('admin.projects.index', compact('projects', 'filter'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        /* RETURN NELLA STESSA PAGINA */
        return view('admin.projects.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProjectRequest $request)
    {
        $data = $request->validated();

        $project = new Project();

        $project->fill($data);

        $project->slug = Str::slug($project->title);

        $project->is_published = array_key_exists('is_published', $data );

        $project->save();
        
        return to_route('admin.projects.show', $project->id)->with('type', 'success')->with('message', "Elemento ( $project->title ) salvato");
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        /* RETURN NELLA STESSA PAGINA */
        return view('admin.projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('admin.projects.edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return to_route('admin.projects.index');
    }

    public function trash()
    {
        
        return view('admin.projects.trash');
    }
    
    public function restore(string $id)
    {

        return to_route('admin.projects.index');
    }

    public function drop(string $id)
    {
        
        return to_route('admin.projects.index');
    }
}