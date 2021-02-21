<?php

namespace App\Providers;
use View;
use Illuminate\Support\ServiceProvider;
use App\CategoriaReceta;

class CategoriasProvider extends ServiceProvider
{

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('*', function($view){
            $categorias = CategoriaReceta::all();
            $view->with('categorias', $categorias);
        });
    }
}
