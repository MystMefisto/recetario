<?php

namespace App\Http\Controllers;

use App\Receta;
use App\CategoriaReceta;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class InicioController extends Controller
{
    //

    public function index(){

        //Mostrar las recetas por cantidad de votos
        //La linea de acontinuación puede usarse para buscar a través de un filtro
        //$votadas = Receta::has('likes','>',1)->get();
        $votadas = Receta::withCount('likes')->orderBy('likes_count', 'desc')->take(5)->get();


        //Obtener las recetas más nuevas
        $nuevas = Receta::orderBy('created_at', 'ASC')->limit(10)->get();
        //De igual forma, para enviar la cantidad de datos que deseemos, podemos usar take() en vez de limit
        //Podemos traer lo más nuevo más fácil por ser tan común simplemente poniendo:
        //$nuevas = Receta::lastest()->get();
        //Y para traer los más viejos usamos oldest
        //$nuevas = Receta::oldest()->get();

        //Obtener todas las categorias
        $categorias = CategoriaReceta::all();
        //return $categorias;

        //Agrupar las recetas por categoria
        $recetas = [];
        foreach($categorias as $categoria){
            $recetas[ Str::slug($categoria->nombre) ][] = Receta::where('categoria_id', $categoria->id)->get();
        }
        //return $recetas;


        return view("inicio.index", compact('nuevas', 'recetas','votadas'));
    }
}
