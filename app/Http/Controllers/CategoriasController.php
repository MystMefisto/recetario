<?php

namespace App\Http\Controllers;
use App\Receta;
use App\CategoriaReceta;
use Illuminate\Http\Request;

class CategoriasController extends Controller
{
    public function show(categoriaReceta $categoriaReceta){
        $recetas = Receta::where('categoria_id', $categoriaReceta->id)->paginate(10);
        return view('categorias.show', compact('recetas', 'categoriaReceta'));
    }
}
