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

        /* RECUPERO VALIDAZIONE */
        $data = $request->validated();

        /* CREO NUOVA ISTANZA */
        $project = new Project();

        /* DATI VALIDATI */
        $project->fill($data);

        /* SLUG */
        $project->slug = Str::slug($project->title);

        /* VERIFICO SE ESISTE NELL'ARRAY ASSOCIATIVO DATA LA CHIAVE IS_PUBLISHED */
        $project->is_published = array_key_exists('is_published', $data);

        /* SALVATAGGIO */
        $project->save();

        /* RETURN SULLA SHOW CON ID E CREO MESSAGGIO ALERT */
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
    public function edit(Project $project)
    {
        /* RETURN NELLA STESSA PAGINA */
        return view('admin.projects.edit', compact('project'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {
        /* RECUPERO VALIDAZIONE */
        $data = $request->validated();

        /* DATI VALIDATI */
        $project->fill($data);

        /* SLUG */
        $project->slug = Str::slug($project->title);

        /* VERIFICO SE ESISTE NELL'ARRAY ASSOCIATIVO DATA LA CHIAVE IS_PUBLISHED */
        $project->is_published = array_key_exists('is_published', $data);

        /* SALVATAGGIO */
        $project->save();

        /* RETURN SULLA SHOW CON ID E CREO MESSAGGIO ALERT */
        return to_route('admin.projects.show', $project->id)->with('type', 'info')->with('message', "Elemento ( $project->title ) aggiornato");;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        /* ELIMINI ELEEMNTO */
        $project->delete();

        /* RETURN SULLA INDEX E CREO MESSAGGIO ALERT */
        return to_route('admin.projects.index')->with('type', 'secondary')->with('message', "Elemento ( $project->title ) messo nel cestino");
    }

    public function trash()
    {
        /* RECUPERO TUTTI I PROGETTI ELIMINATI */
        $projects = Project::onlyTrashed()->get();
        
        /* RETURN NELLA STESSA PAGINA */
        return view('admin.projects.trash', compact('projects'));
    }

    public function restore(string $id)
    {
        /* RECUPERO ELEMENTO CON ID SPECIFICO SE ELEMINATO */
        $projects = Project::onlyTrashed()->findOrFail($id);

        /* RIPRISTINO */
        $projects->restore();

        /* RETURN SULLA INDEX E CREO MESSAGGIO ALERT */
        return to_route('admin.projects.index')->with('type', 'success')->with('message', "Elemento ( $projects->title ) ripreso dal cestino");
    }

    public function drop(string $id)
    {
        /* RECUPERO ELEMENTO CON ID SPECIFICO SE ELEMINATO */
        $projects = Project::onlyTrashed()->findOrFail($id);
        
        /* ELIMINO DEFINITIVAMENTE L'ELEMENTO */
        $projects->forceDelete();
        
        /* RETURN SULLA INDEX E CREO MESSAGGIO ALERT */
        return to_route('admin.projects.index')->with('type', 'danger')->with('message', "Elemento ( $projects->title ) eliminato");
    }
}