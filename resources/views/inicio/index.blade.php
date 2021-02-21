@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.css" integrity="sha512-UTNP5BXLIptsaj5WdKFrkFov94lDx+eBvbKyoe1YAfjeRPC+gT5kyZ10kOHCfNZqEui1sxmqvodNUx3KbuYI/A==" crossorigin="anonymous" />
@endsection

@section('hero')
    <div class="hero-categorias">
        <form class="container h-100" action={{route('buscar.show')}}>
            <div class="row h-100 align-items-center">
                <div class="col-md-4 texto-buscar">
                    <p class="display-4">
                        Encuentra una receta para tu próxima comida
                    </p>

                    <input type="search"
                    name="buscar"
                    class="form-control"
                    placeholder="Buscar Receta"
                    />
                </div>
            </div>
        </form>
    </div>
@endsection

@section('content')

<div class="container nuevas-recetas">
    <h2 class="titulo-categoria text-uppercase mt-5 mb-4">Últimas recetas</h2>
    <div class="owl-carousel owl-theme">
        @foreach($nuevas as $nueva)
            <div class="card">
                <img src="/storage/{{$nueva->imagen}}" class="card-img-top" alt="Imagen receta">
                <div class="card-body">
                    <h3>
                        {{$nueva->titulo}}
                    </h3>
                    <p>
                        {{ Str::words( strip_tags( $nueva->preparacion ), 12) }}
                    </p>
                    <a href="{{route('recetas.show', ['receta' => $nueva->id])}}" class="btn btn-primary d-block font-weight-bold align-bottom btn-receta"> Ver receta</a>
                </div>
        </div>
        @endforeach
    </div>
</div>

<div class="container">
    <h2 class="titulo-categoria mt-5 mb-4 text-capitalize">
        Recetas más votadas
    </h2>
    <div class="row">
            @foreach($votadas as $receta)
                @include('ui.receta')
            @endforeach
    </div>
</div>

@foreach ($recetas as $key => $grupo)
    <div class="container">
        <h2 class="titulo-categoria mt-5 mb-4 text-capitalize">
            {{str_replace('-',' ',$key)}}
        </h2>
        <div class="row">
            @foreach($grupo as $recetas)
                @foreach($recetas as $receta)
                    @include('ui.receta')
                @endforeach
            @endforeach
        </div>
    </div>

@endforeach

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
