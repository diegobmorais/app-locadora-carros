<?php

namespace App\Http\Controllers;

use App\Models\Marca;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

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
        $marca = Marca::create($request->all());        
        return $marca;
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {     
        try{
            $marca = Marca::findOrFail($id);
            return $marca;
        }catch(ModelNotFoundException $e){
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
            $marca->update($request->all());            
            return $marca;
        } catch (ModelNotFoundException $e) {
            return response()->json(['erro' => 'marca não existe'], 404);
        }        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $marca = Marca::findOrFail($id); 
            $marca->delete();
            return ['mensagem' => 'A marca foi removida com sucesso'];
        } catch (ModelNotFoundException $e) {
            return response()->json(['erro' => 'marca não existe'], 404);
        } 
        
    }
}
