@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/trix/1.3.1/trix.css" integrity="sha512-CWdvnJD7uGtuypLLe5rLU3eUAkbzBR3Bm1SFPEaRfvXXI2v2H5Y0057EMTzNuGGRIznt8+128QIDQ8RqmHbAdg==" crossorigin="anonymous" />
@endsection
@section('botones')

<a href="{{route('recetas.index')}}" class="btn btn-primary text-white">
    <svg class="iconedit" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm.707-10.293a1 1 0 00-1.414-1.414l-3 3a1 1 0 000 1.414l3 3a1 1 0 001.414-1.414L9.414 11H13a1 1 0 100-2H9.414l1.293-1.293z" clip-rule="evenodd" />
      </svg>
    Volver</a>

@endsection


@section('content')

    <h1 class="text-center">Editar mi perfil</h1>

    <div class="row justify-content-center mt-5">
        <div class="col-md-10 bg-white p3">
            <form action=" {{route('perfiles.update',['perfil'=>$perfil->id])}} "
                method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="nombre">Nombre</label>
                    <input type="text" id="url" name="nombre" class="form-control @error('nombre') is-invalid @enderror" placeholder="Tu nombre"
                    value="{{ $perfil->usuario->name }}">
                </div>

                @error('nombre')
                    <span class="invalid-feedback d-block" role="alert">
                        <strong>{{$message}}</strong>
                    </span>
                @enderror

                <div class="form-group">
                    <label for="url">Sitio web</label>
                    <input type="text" id="url" name="url" class="form-control @error('url') is-invalid @enderror" placeholder="Dirección de tu sitio web"
                    value="{{ $perfil->usuario->url }}">
                </div>

                @error('url')
                    <span class="invalid-feedback d-block" role="alert">
                        <strong>{{$message}}</strong>
                    </span>
                @enderror

                <div class="form-group mt-3">
                    <label for="biografia">Biografia</label>
                    <input id="biografia" type="hidden" name="biografia" value="{{ $perfil->biografia }}">
                    <trix-editor
                    class="trix-content form-control @error('biografia') is-invalid @enderror"
                    input="biografia"></trix-editor>

                    @error('biografia')
                    <span class="invalid-feedback d-block" role="alert">
                        <strong>{{$message}}</strong>
                    </span>
                    @enderror
                </div>

                <div class="form-group mt-3">
                    @if($perfil->imagen)
                    <p class="text-primary">Imagen actual</p>
                    <img src="/storage/{{$perfil->imagen}}" style="width:300px" class="mb-4">
                    @endif
                    <label for="imagen">Elige una foto de perfil</label>

                    <input
                    id="imagen"
                    type="file"
                    class="form-control @error('imagen') is-invalid @enderror"
                    name="imagen">

                    @error('imagen')
                    <span class="invalid-feedback d-block" role="alert">
                        <strong>{{$message}}</strong>
                    </span>
                    @enderror
                </div>

                <div class="form-group">
                    <input type="submit" class="btn btn-primary" value="Actulizar perfil">
                </div>

            </form>
        </div>
    </div>

@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/trix/1.3.1/trix.js" integrity="sha512-/1nVu72YEESEbcmhE/EvjH/RxTg62EKvYWLG3NdeZibTCuEtW5M4z3aypcvsoZw03FAopi94y04GhuqRU9p+CQ==" crossorigin="anonymous" defer></script>
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
