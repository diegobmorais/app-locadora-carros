<?php

namespace App\Http\Controllers;

use App\Models\Marca;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MarcaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $marca = Marca::all();
        return $marca;
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
        $request->validate(Marca::rules(), Marca::feedback());

        $imagem = $request->file('imagem');
        $imagem_urn = $imagem->store('imagens', 'public');

        $marca = Marca::create([
            'nome' => $request->nome,
            'imagem' => $imagem_urn,
        ]);
        return response()->json($marca, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $marca = Marca::findOrFail($id);
            return $marca;
        } catch (ModelNotFoundException $e) {
            return response()->json(['erro' => 'marca não existe'], 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Marca $marca)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $marca = Marca::findOrFail($id);

            if ($request->method() === 'PATCH') {
                $regrasDinamicas = array();
                foreach (Marca::rules() as $input => $rule) {
                    if (array_key_exists($input, $request->all())) {
                        $regrasDinamicas[$input] = $rule;
                    }
                }
                $request->validate($regrasDinamicas, Marca::feedback());
            } else {
                $request->validate(Marca::rules(), Marca::feedback());
            }
            //remove imagem antiga apos atualização
            if ($request->file('imagem')) {
                Storage::disk('public')->delete($marca->imagem);
            }
            $imagem = $request->file('imagem');
            $imagem_urn = $imagem->store('imagens', 'public');

            $marca->update([
                'nome' => $request->nome,
                'imagem' => $imagem_urn,
            ]);

            return response()->json($marca, 201);
        } catch (ModelNotFoundException $e) {
            return response()->json(['erro' => 'marca não existe'], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id, Request $request)
    {
        try {
            $marca = Marca::findOrFail($id);
            if ($request->file('imagem')) {
                Storage::disk('public')->delete($marca->imagem);
            }
            $marca->delete();
            return ['mensagem' => 'A marca foi removida com sucesso'];
        } catch (ModelNotFoundException $e) {
            return response()->json(['erro' => 'marca não existe'], 404);
        }
    }
}
