<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Marca extends Model
{
    use HasFactory;
    protected $fillable = [
        'nome',
        'imagem',
    ];
    static function rules()
    {
        return [
            'nome' => 'required|unique:marcas',
            'imagem' => 'required' // acrescentar (file|mimes:png,jpge)
        ];
    }
    static function feedback()
    {
        return [
            'required' => 'O campo :attribute é obrigatório',
            'nome.unique' => 'O nome da marca já existe'
        ];
    }
}
