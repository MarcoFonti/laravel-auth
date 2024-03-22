<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    /* ELIMINAZIONE SOFT */
    use SoftDeletes;

    /* FUNZIONE DI DATA CREAZIONE */
    public function getCreatedAt()
    {
        return Carbon::create($this->created_at)->format('d-m-Y H:i:s');
    }
    
    /* FUNZIONE DI DATA MODIFICA */
    public function getUpdatedAt()
    {
        return Carbon::create($this->update_at)->format('d-m-Y H:i:s',);
    }
}