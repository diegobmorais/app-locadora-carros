<?php

namespace App\Http\Controllers;

use App\Models\Modelo;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ModeloController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $modelo = Modelo::all();
        return $modelo;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(Modelo::rules());

        $imagem = $request->file('imagem');
        $imagem_urn = $imagem->store('imagens/modelos', 'public');

        $modelo = Modelo::create([
            'marca_id' => $request->marca_id,
            'nome' => $request->nome,
            'imagem' => $imagem_urn,
            'numero_portas' => $request->numero_portas,
            'lugares' => $request->lugares,
            'air_bag' => $request->air_bag,
            'abs' => $request->abs,
        ]);
        return response()->json($modelo, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $modelo = Modelo::findOrFail($id);
            return $modelo;
        } catch (ModelNotFoundException $e) {
            return response()->json(['erro' => 'modelo não existe'], 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Modelo $modelo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $modelo = Modelo::findOrFail($id);

            if ($request->method() === 'PATCH') {
                $regrasDinamicas = array();
                foreach (Modelo::rules() as $input => $rule) {
                    if (array_key_exists($input, $request->all())) {
                        $regrasDinamicas[$input] = $rule;
                    }
                }
                $request->validate($regrasDinamicas);
            } else {
                $request->validate(Modelo::rules());
            }
            //remove imagem antiga apos atualização
            if ($request->file('imagem')) {
                Storage::disk('public')->delete($modelo->imagem);
            }
            $imagem = $request->file('imagem');
            $imagem_urn = $imagem->store('imagens', 'public');

            $modelo->update([
                'marca_id' => $request->marca_id,
                'nome' => $request->nome,
                'imagem' => $imagem_urn,
                'numero_portas' => $request->numero_portas,
                'lugares' => $request->lugares,
                'air_bag' => $request->air_bag,
                'abs' => $request->abs,
            ]);

            return response()->json($modelo, 201);
        } catch (ModelNotFoundException $e) {
            return response()->json(['erro' => 'marca não existe'], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id)
    {
        try {
            $modelo = Modelo::findOrFail($id);
            if ($request->file('imagem')) {
                Storage::disk('public')->delete($modelo->imagem);
            }
            $modelo->delete();
            return ['mensagem' => 'A marca foi removida com sucesso'];
        } catch (ModelNotFoundException $e) {
            return response()->json(['erro' => 'marca não existe'], 404);
        }
    }
}
