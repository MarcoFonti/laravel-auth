<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


class StoreProjectRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {

        /* RESTITUISCO CIO' CHE DA ERRORE */
        return [
            'title' => 'required|string|min:5|max:50|unique:projects',
            'content' => 'required|string',
            'image' => 'nullable|url',
            'is_published' => 'nullable|boolean',
        ];
    }

    public function messages(): array
    {

        /* RECUPERO TUTTO I DATI */
        $data = $this->all();
        
        /* RESTITUISCO CIO' CHE DARA' IL MESSAGGIO DI ERRORE */
        return [
            'title.required' => 'Il campo Titolo è obbligatorio',
            'title.min' => 'Il campo Titolo deve essere almeni :min caratteri',
            'title.max' => 'Il campo Titolo deve essere almeni :max caratteri',
            'title.unique' => "Esiste già questo nome {$data['title']}",
            'content.required' => 'Il contenuto è obbligatorio ',
        ];
    }
}