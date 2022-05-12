<?php

namespace App\Http\Controllers;

use App\Models\Marca;
use App\Models\Producto;
use Illuminate\Http\Request;

class MarcaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $marcas = Marca::all();
        $marcas = Marca::paginate(7);
        // return 'metodo index';
        return view('marcas', [ 'marcas' => $marcas ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('marcaCreate');
    }

    // este es un metodo validador creado por mi
    private function validarForm( Request $request )
    {
        $request->validate(
            [ 'mkNombre'=>'required|min:2|max:50' ],
            [
                'mkNombre.required' => 'El campo "Nombre de la marca" es obligatorio.',
                'mkNombre.min' => 'El campo "Nombre de la marca" debe tener 2 caracteres como mínimo.',
                'mkNombre.max' => 'El campo "Nombre de la marca" no puede superar los 50 caracteres.'
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
        // captura de datos enviados
        $mkNombre = $request->mkNombre;

        // validacion
        $this->validarForm( $request );

        //instanciar + asignar atributos
        $Marca = new Marca;
        $Marca->mkNombre = $mkNombre;

        // guardar
        $Marca->save();

        // retorno respuesta - flashing de mensaje ok
        return redirect('/marcas')->with(['mensaje' =>'Marca: '.$mkNombre.' agregada correctamente.']);
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
        //obtener los datos filtrados con su id
        // DB::table('marcas')->where( 'idMarca', $id )->first();
        $Marca = Marca::find( $id );

        // retorno vista del form pasandole la marca
        return view( 'marcaEdit', [ 'Marca'=>$Marca ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function update(Request $request, $id) el $id lo elimino porque no lo estoy pasando
    public function update(Request $request)
    {

        $mkNombre = $request->mkNombre;

        $this->validarForm($request); //valido
        $Marca = Marca::find( $request->idMarca ); //traigo los datos segun su id

        $Marca->mkNombre = $mkNombre;//asigno nuevo valor

        $Marca->save();//guardo en BD

        // retorno respuesta - flashing de mensaje ok
        return redirect('/marcas')->with(['mensaje' =>'Marca: '.$mkNombre.' modificada correctamente.']);
    }
    /*
    private function productoPorMarca( $idMarca )
    {
        // $check = Producto::where('idMarca', $idMarca)->first();//si hay o no hay
        $check = Producto::firstWhere('idMarca', $idMarca);//si hay o no hay
        // $check = Producto::where('idMarca', $idMarca)->count();//cuantos hay
        return $check;
    }
*/
    public function confirm( $id )
    {
        // obtenemos datos de la marca
        $Marca = Marca::find( $id );

        //si no hay productos de esa marca
        if( !$this->productoPorMarca( $id ))
        {
            //devuelvo la vista de confirmacion
            return view( 'marcaDelete', [ 'Marca' => $Marca ] );
        }

        //si hay productos con esa marca redirecciono con un flashing de que no se puede eliminar
        return redirect('/marcas')
                ->with([
                    'warning' => 'warning',
                    'mensaje' => 'No se puede eliminar '.$Marca->mkNombre.' porque tiene productos relacionados'
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
        $Marca = Marca::find( $request->idMarca );
        $Marca::delete();
        */

        Marca::destroy( $request->idMarca );
        // retorno respuesta - flashing de mensaje ok
        return redirect('/marcas')->with(['mensaje' =>'Marca: '.$request->mkNombre.' eliminada correctamente.']);

    }
}
