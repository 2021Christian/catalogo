<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Producto;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $categorias = Categoria::all();
        $categorias = Categoria::paginate(7);

        return view('categorias', [ 'categorias' => $categorias ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('categoriaCreate');
    }

    // validador propio
    private function validarForm( Request $request )
    {
        $request->validate(
            ['catNombre'=>'required|min:2|max:30'],
            [
                'catNombre.required' => 'El campo "Nombre de la categoría" es obligatorio.',
                'catNombre.min' => 'El campo "Nombre de la categoría" debe tener 2 caracteres como mínimo.',
                'catNombre.max' => 'El campo "Nombre de la categoría" no puede superar los 30 caracteres.'
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $catNombre = $request->catNombre;// captura de datos enviados

        $this->validarForm( $request ); // validacion

        $Categoria = new Categoria; //instanciar
        $Categoria->catNombre = $catNombre; // asignar atributos
        $Categoria->save(); // guardar

        // retorno respuesta - flashing de mensaje ok
        return redirect( '/categorias' )
                ->with([ 'mensaje'=>'Categoría '.$catNombre.' agregada correctamente.' ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //genero el obj con la categoria a modificar
        $Categoria = Categoria::find( $id );

        // retorno la vista del form de modificacion con los datos buscados
        return view('categoriaEdit', [ 'Categoria' => $Categoria ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request )
    {
        $catNombre = $request->catNombre;
        // dd($catNombre);

        $this->validarForm( $request ); //llamo al validador
        $Categoria = Categoria::find( $request->idCategoria ); //traigo los datos del id
        $Categoria->catNombre = $catNombre; //asigno nuevo valor
        $Categoria->save(); //guardo en BD

        // retorno respuesta - flashing de mensaje ok
        return redirect('/categorias')
                ->with([ 'mensaje' =>'Categoria: '.$catNombre.' modificada correctamente.' ]);
    }

    private function productoPorCategoria( $idCategoria )
    {
        // $check = Producto::where('idCategoria', $idCategoria)->first();//si hay o no hay
        $check = Producto::firstWhere('idCategoria', $idCategoria);//si hay o no hay
        // $check = Producto::where('idCategoria', $idCategoria)->count();//cuantos hay
        return $check;
    }

    public function confirm( $id )
    {
        $Categoria = Categoria::find( $id ); //traigo datos de la categoria

        //si no hay productos de esa categoria
        if( !$this->productoPorCategoria( $id ))
        {
            //devuelvo la vista de confirmacion
            return view( 'categoriaDelete', [ 'Categoria' => $Categoria ] );
        }

        //si hay productos con esa categoria redirecciono con un flashing de que no se puede eliminar
        return redirect('/categorias')
                ->with([
                    'warning' => 'warning',
                    'mensaje' => 'No se puede eliminar '.$Categoria->catNombre.' porque tiene productos relacionados'
                ]);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy( Request $request )
    {
        /*
        $Categoria = Categoria::find( $request->idCategoria );
        $Categoria::delete();
        */
        Categoria::destroy( $request->idCategoria );

        // retorno respuesta - flashing de mensaje ok
        return redirect('/categorias')->with(['mensaje' =>'Categoria: '.$request->catNombre.' eliminada correctamente.']);

    }
}
