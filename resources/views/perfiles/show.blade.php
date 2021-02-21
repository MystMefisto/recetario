@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-3 profile-img">
            @if($perfil->imagen===null)
            <img class="w-100 rounded-circle" src="http://cocinarte.co/wp-content/uploads/2015/08/ThinkstockPhotos-175124905.jpg"
            alt="Imagen default. Este no es el chef de este perfil">
        @else
            <img class="w-100 rounded-circle" src="/storage/{{$perfil->imagen}}">
        @endif

        <h2 class="text-center mb-2 text-primary">
            {{$perfil->usuario->name}}
        </h2>
        @can('update', $perfil)
        <div class="text-center">

            @if($perfil->usuario->email_verified_at === null)
                    <p class="text-danger">No verificado</p>
                    @else
                    <p class="text-success">Verificado</p>
                    @endif
        </div>
        @endcan

        <div class="text-center mb-2">
                <a href="{{$perfil->usuario->url}}">
                    Visitar web
                </a>
                <p class="text-center mb-2">
                    <b> Se unió el
                        <fecha-receta fecha="{{ $perfil->usuario->created_at }}"></fecha-receta>
                    </b>
                </p>
            </div>
            @can ('update',$perfil)
            <div class="align-bottom btn-edit-profile">
                <a href="{{route('perfiles.edit', ['perfil' => Auth::user()->id])}}" class="w-100 btn btn-outline-success font-weight-bold">Editar perfil</a>
            </div>
            @endcan
        </div>

        <div class="col-md-7 mt-5 mt-md-0">

            <div class="biografia text-center">
                <h3 class="text-primary">Biografia:</h3>
                @if(empty($perfil->biografia))
                    <p>No hay biografia.</p>
                @else
                <div class="text-left">
                    {!! $perfil->biografia !!}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

    <h2 class="text-center my-5"> Recetas creadas por {{$perfil->usuario->name}} </h2>
    <div class="container">
        <div class="row mx-auto bg-white p-4">
            @if(count($recetas)>0)
                @foreach($recetas as $receta)
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <img src="/storage/{{$receta->imagen}}" class="card-img-top" alt="Imagen receta">
                            <div class="card-body">
                                <h3> {{$receta->titulo}} </h3>
                                <a href=" {{route('recetas.show', ['receta'=>$receta->id])}} " class="btn btn-primary d-block mt-4 font-weight-bold">Ver receta</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
            <p class="text-center w-100">No hay recetas...</p>
            @endif
        </div>

        <div class="d-flex justify-content-center">
            {{$recetas->links()}}
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
