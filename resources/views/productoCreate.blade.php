@extends('layouts.plantilla')
@section('contenido')

    <h1>Alta de un nuevo producto</h1>

    <div class="alert p-4 col-8 mx-auto shadow">
        <form action="/producto/store" method="post" enctype="multipart/form-data">
        @csrf

            <div class="form-group mb-4">
                <label for="prdNombre">Nombre del Producto</label>
                <input type="text" name="prdNombre" value="{{ old('prdNombre')}}"
                       class="form-control" id="prdNombre">
            </div>

            <label for="prdPrecio">Precio del Producto</label>
            <div class="input-group mb-4">
                <div class="input-group-prepend">
                    <div class="input-group-text">$</div>
                </div>
                <input type="number" name="prdPrecio" value="{{ old('prdPrecio')}}"
                       class="form-control" id="prdPrecio" min="0" step="0.50">
            </div>

            <div class="form-group mb-4">
                <label for="idMarca">Marca</label>
                <select class="form-select" name="idMarca" id="idMarca">
                    <option value="">Seleccione una marca</option>
                    @foreach ($marcas as $marca)

                        <option value="{{ $marca->idMarca }}" {{ ( $marca->idMarca == old('idMarca') )?"selected":"" }}>
                            {{ $marca->mkNombre }}
                        </option>

                    @endforeach
                </select>
            </div>

            <div class="form-group mb-4">
                <label for="idCategoria">Categoría</label>
                <select class="form-select" name="idCategoria" id="idCategoria">
                    <option value="">Seleccione una categoría</option>
                    @foreach ($categorias as $categoria)

                        <option value="{{ $categoria->idCategoria }}" {{ ( $categoria->idCategoria == old('idCategoria') )?"selected":"" }}>
                            {{ $categoria->catNombre }}
                        </option>

                    @endforeach
                </select>
            </div>

            <div class="form-group mb-4">
                <label for="prdDescripcion">Descripción del Producto</label>
                <textarea name="prdDescripcion" class="form-control" id="prdDescripcion">{{ old('prdDescripcion')}}</textarea>
            </div>

            {{--
            <div class="form-group mb-4">
                <label for="prdStock">Stock del Producto</label>
                <input type="number" name="prdStock" value="{{ old('prdStock') }}"
                    class="form-control" id="prdStock" min="0">
            </div>
            --}}

            <div class="custom-file mt-1 mb-4">
                <input type="file" name="prdImagen"  class="custom-file-input" id="customFileLang" lang="es">
                <label class="custom-file-label" for="customFileLang" data-browse="Buscar en disco">Seleccionar Archivo: </label>
            </div>

            <button class="btn btn-dark mr-3 px-4">Agregar producto</button>
            <a href="/productos" class="btn btn-outline-secondary">
                Volver a panel de productos
            </a>

        </form>
    </div>

    @if( $errors->any() )
       <div class="alert alert-danger col-8 mx-auto">
           <ul>
           @foreach( $errors->all() as $error )
               <li>{{ $error }}</li>
           @endforeach
           </ul>
       </div>
   @endif

@endsection
