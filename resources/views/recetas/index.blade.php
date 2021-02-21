@extends('layouts.app')
@section('botones')
    @include('ui.navegacion')
@endsection
@section('content')
<h2 class="text-center mb-5">Administra tus recetas</h2>

<div class="col-md-10 mx-auto p3">
    <table class="table">
        <thead class="bg-primary text-light">
            <tr>
                <th scole="col">Titulo</th>
                <th scole="col">Categoría</th>
                <th scole="col">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($recetas as $receta)

            <tr>
                <td>{{$receta->titulo}}</td>
                <td>{{$receta->categoria->nombre}}</td>
                <td>
                    <eliminar-receta receta-id={{$receta->id}}></eliminar-receta>
                    <a href="{{ route('recetas.edit', ['receta' => $receta->id] )}}" class="btn btn-dark d-block mb-2 response-full">Editar</a>
                    <a href="{{ route('recetas.show', ['receta' => $receta->id] )}}" class="btn btn-success d-block mb-2 response-full">Ver</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="col-12 mt-4 justify-content-center d-flex">
        {{ $recetas->links() }}
    </div>

    <h2 class="text-center my-5">Recetas que me gustan</h2>
    <div class="col-md-10 mx-auto p3">

        @if( count($usuario->meGusta) > 0)
        <ul class="list-group">
            @foreach($usuario->meGusta as $receta)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <p>
                        {{$receta->titulo}}
                    </p>
                    <a class="btn btn-outline-success" href=" {{route('recetas.show',['receta' => $receta->id])}} ">Ver</a>
                </li>
            @endforeach
        </ul>
        @else
            <p class="text-center">Aún no tienes recetas guardadas.
               <br> <small>Dale me gusta a varias recetas para que aparezca acá.</small>
            </p>
        @endif
    </div>
</div>

@endsection

@section('footer')

    <!-- Grid container -->

    <!-- Copyright -->
    <div class="text-center text-white p-3" style="background-color: rgb(0, 0, 0);">
      © 2021 Copyright: Made by
      <a class="text-white" href="https://mdbootstrap.com/"> MystMefisto</a>
    </div>
    <!-- Copyright -->
  </footer>

@endsection
