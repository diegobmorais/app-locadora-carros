<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Modelo extends Model
{
    use HasFactory;
    protected $fillable = [
        'marca_id',
        'nome',
        'imagem',
        'numero_portas',
        'lugares',
        'air_bag',
        'abs'
    ];
    static function rules()
    {
        return [
            'nome' => 'required|unique:marcas',
            'imagem' => 'required' // acrescentar (file|mimes:png,jpge)
        ];
    }
    public function marca()
    {
        return $this->belongsTo(Marca::class, 'marca_id');
    }
}
