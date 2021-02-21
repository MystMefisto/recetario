<?php

namespace App\Http\Controllers;

use App\Receta;
use App\CategoriaReceta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;

class RecetaController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth',['except' => ['show','search']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        //$recetas = auth()->user()->recetas;

        //Para hacer paginación es necesario irse al modelo
        $usuario = auth()->user();
        $recetas = Receta::where('user_id', $usuario->id)->paginate(3);
        return view('recetas.index')
        ->with('recetas',$recetas)
        ->with('usuario',$usuario);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //DB::table('categoria_receta')->get()->pluck('nombre','id');

        //Sin categoria
        //$categorias = DB::table('categorias')->get()->pluck('nombre');
        //Con modelo
        $categorias = CategoriaReceta::all(['nombre','id']);

        //$categorias = DB::table('categoria_recetas')->get()->pluck('nombre','id');

        return view('recetas.create')->with('categorias', $categorias);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
{

        //Validación

        $data =request()->validate([
            'titulo' => 'required|min:6',
            'categoria' => 'required',
            'preparacion' => 'required',
            'ingredientes' => 'required',
            'imagen' => 'required|image'
        ]);

        //Obtener la ruta de la imagen

        $ruta_imagen = $request['imagen']->store('upload-recetas','public');

        //Resize de la imagen
        $img = Image::make(public_path("storage/{$ruta_imagen}"))->fit(1200,550);
        $img->save();

        //Almacenar en la base de datos(sin modelos)

//        DB::table('recetas')->insert(
//            [
//                'titulo' => $data['titulo'],
//                'preparacion' => $data['preparacion'],
//                'ingredientes' => $data['ingredientes'],
//                'imagen' => $ruta_imagen,
//                'user_id' => Auth::user()->id,
//                'categoria_id' => $data['categoria']


            //almacenar en la BD(con modelo)
            auth()->user()->recetas()->create([
                'titulo' => $data['titulo'],
                'preparacion' => $data['preparacion'],
                'ingredientes' => $data['ingredientes'],
                'imagen' => $ruta_imagen,
                'categoria_id' => $data['categoria']
            ]);

        //Redirecionar
        return redirect()->action('RecetaController@index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Receta $receta
     * @return \Illuminate\Http\Response
     */
    public function show(Receta $receta)
    {

        //Obtener si el usuario actual le gusta la receta y está autenticado
        $like = ( auth()->user() ) ? auth()->user()->meGusta->contains($receta->id) : false;


        //Pasa la cantidad de likes
        $likes = $receta->likes->count();

        return view('recetas.show', compact('receta', 'like', 'likes'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Receta $receta
     * @return \Illuminate\Http\Response
     */
    public function edit(Receta $receta)
    {

        //Revisa el policy
        $this->Authorize('view', $receta);

         //Con modelo
        $categorias = CategoriaReceta::all(['nombre','id']);


        return view('recetas.edit', compact('categorias','receta'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Receta $receta
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Receta $receta)
    {
        //Revisar el policy
        $this->authorize('update', $receta);


        //Validación

        $data =request()->validate([
            'titulo' => 'required|min:6',
            'categoria' => 'required',
            'preparacion' => 'required',
            'ingredientes' => 'required',
        ]);

        //Asignar los valores
        $receta->titulo = $data['titulo'];
        $receta->preparacion = $data['preparacion'];
        $receta->ingredientes = $data['ingredientes'];
        $receta->categoria_id = $data['categoria'];
        $receta->save();

        //Si el usuario sube una nueva imagen
        if(request('image')){
        //Obtener la ruta de la imagen

        $ruta_imagen = $request['imagen']->store('upload-recetas','public');

        //Resize de la imagen
        $img = Image::make(public_path("storage/{$ruta_imagen}"))->fit(1200,550);
        $img->save();

        //asignamos al objeto
        $receta->imagen = $ruta_imagen;
        }

        //redireccionar
        return redirect()->action('RecetaController@index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Receta $receta
     * @return \Illuminate\Http\Response
     */
    public function destroy(Receta $receta)
    {
        //Ejecutar el Policy
        $this->authorize('delete',$receta);

        //Elimnar la receta
        $receta->delete();

        return redirect()->action('RecetaController@index');

    }

    public function search(Request $request){
        //$busqueda = $request['buscar'];
        $busqueda = $request->get('buscar');
        $recetas = Receta::where('titulo','like','%' . $busqueda . '%')->paginate(3);
        $recetas->appends(['buscar' => $busqueda]);
        return view('busquedas.show', compact('recetas','busqueda'));
    }
}
