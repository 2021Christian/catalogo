<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Marca;
use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $productos = Producto::with([ 'getMarca', 'getCategoria' ])->paginate(6);
        return view('productos', [ 'productos' => $productos ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //listado de MArcas y de categorias

        $marcas = Marca::all();
        $categorias = Categoria::all();
        return view('productoCreate',
            [
                'marcas' => $marcas,
                'categorias' => $categorias
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    // Funcion de Validacion de datos de producto
    private function validarForm( Request $request )
    {
        // $request->validate( ['reglas'], ['mensajes'] );
        $request->validate(
            [
                'prdNombre' => 'required|min:2|max:75',
                'prdPrecio' => 'required|numeric|min:0',
                'idMarca' => 'required|int',
                'idCategoria' => 'required|int',
                'prdDescripcion' => 'required|min:2|max:150',
                // 'prdStock' => 'required|int|min:0',
                // 'prdImagen' => 'image'
                'prdImagen' => 'mimes:jpg,jpeg,png,gif,svg,webp|max:2048'//con mimes (mime-type)indico el arch permitido por su extension
            ],
            [
                'prdNombre.required'=>'El campo "Nombre del producto" es obligatorio.',
                'prdNombre.min'=>'El campo "Nombre del producto" debe tener como mínimo 2 caractéres.',
                'prdNombre.max'=>'El campo "Nombre" debe tener 30 caractéres como máximo.',
                'prdPrecio.required'=>'Complete el campo Precio.',
                'prdPrecio.numeric'=>'Complete el campo Precio con un número.',
                'prdPrecio.min'=>'Complete el campo Precio con un número positivo.',
                'idMarca.required'=>'Seleccione una marca.',
                'idMarca.integer'=>'Seleccione una marca.',
                'idCategoria.required'=>'Seleccione una categoría.',
                'idCategoria.integer'=>'Seleccione una categoría.',
                'prdDescripcion.required'=>'Complete el campo Descripción.',
                'prdDescripcion.min'=>'Complete el campo Descripción con al menos 3 caractéres',
                'prdDescripcion.max'=>'Complete el campo Descripción con 150 caractéres como máxino.',
                // 'prdStock.required'=>'Complete el campo Stock.',
                // 'prdStock.integer'=>'Complete el campo Stock con un número entero.',
                // 'prdStock.min'=>'Complete el campo Stock con un número positivo.',
                'prdImagen.mimes'=>'Debe ser una imagen.',
                'prdImagen.max'=>'Debe ser una imagen de 2MB como máximo.'
            ]);
    }

    private function subirImagen(Request $request)
    {
        // si no enviaron imagen 'noDisponible.png'
        $prdImagen = 'noDisponible.png';

        // si enviaron una imagen
            //$request->file('campoDelForm') devuelve true o false si hay o no un archivo que se envio en ese campo
        if($request->file('prdImagen'))
        {
            //renombro el archivo
            $extension = $request->file('prdImagen')->extension();
            $prdImagen = time() . '.' . $extension; //concatena time().$extension

            //subo archivo
            $request->file( 'prdImagen' )
                    ->move( public_path( 'imagenes/productos/'), $prdImagen );
        }

        // retorno el nombre
        return $prdImagen;

    }


    public function store(Request $request)
    {
        //valido
        $this->validarForm($request);
            // si no pasa la validacion -> redirige al formulario

        //subo imagen   //noDisponible.png imagen por defecto si no se sube ninguna
        $prdImagen = $this->subirImagen( $request );

        //instancia
        $Producto = new Producto();
        $Producto->prdNombre = $request->prdNombre;
        $Producto->prdPrecio = $request->prdPrecio;
        $Producto->idMarca = $request->idMarca;
        $Producto->idCategoria = $request->idCategoria;
        $Producto->prdDescripcion = $request->prdDescripcion;
        // $Producto->prdStock = $request->prdStock;
        $Producto->prdImagen = $prdImagen;
        $Producto->prdActivo = 1;
        $Producto->save();

        //redirecciono y paso un mensaje
        return redirect('/productos')
            ->with( [ 'mensaje'=>'Producto: '.$request->prdNombre.' agregado correctamente.' ] );


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function show(Producto $producto)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function edit(Producto $producto)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Producto $producto)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function destroy(Producto $producto)
    {
        //
    }
}
