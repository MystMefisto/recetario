@extends ('layouts.app')

@section('content')

<article class="contenido-recetas">
    <h1 class="text-center mb-4">
        {{$receta->titulo}}
    </h1>
    <div class="imagen-receta">
        <img src="/storage/{{$receta->imagen}}" class="w-100">
    </div>
    <div class="receta-meta mt-2">
        <p>
            <span class="font-weight-bold text-primary">Escrito en:</span>
            <a class="text-dark" href="{{route('categorias.show',['categoriaReceta'=>$receta->categoria->id])}}">
                {{$receta->categoria->nombre}}
            </a>
        </p>
        <p>
            <span class="font-weight-bold text-primary">Autor:</span>
            <a class="text-dark" href="{{ route('perfiles.show', ['perfil' => Auth::user()->id]) }}">
            {{$receta->autor->name}}
            </a>
        </p>
        <span class="font-weight-bold text-primary">Fecha:</span>
        @php
            $fecha = $receta->created_at;
        @endphp
            <fecha-receta fecha="{{$fecha}}"></fecha-receta>
    </p>



        <div class="ingredientes">
            <h2 class="my-3 text-primary"> Ingredientes</h2>
            {!! $receta->ingredientes !!}
        </div>
        <div class="preparacion">
            <h2 class="my-3 text-primary"> Preparación</h2>
            {!! $receta->preparacion !!}
        </div>

            <div class="justify-content-center row text-center">
                <like-button
                    likes="{{$likes}}"
                    like="{{$like}}"
                    receta-id="{{$receta->id}}">
                </like-button>
            </div>
    </div>
</article>

@endsection