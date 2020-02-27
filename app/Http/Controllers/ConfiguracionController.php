<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Configuracion;
use Session;
use Auth;

class ConfiguracionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort(401);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort(401);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        abort(401);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        abort(401);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id=null)
    {
        $configuracion = Configuracion::find($id);
        $horaInicial = array('04:00:00'=>'04:00:00','05:00:00'=>'05:00:00','06:00:00'=>'06:00:00','07:00:00'=>'07:00:00','08:00:00'=>'08:00:00','09:00:00'=>'09:00:00','10:00:00'=>'10:00:00');
        $horaFinal = array('15:00:00'=>'15:00:00','16:00:00'=>'16:00:00','17:00:00'=>'17:00:00','18:00:00'=>'18:00:00','19:00:00'=>'19:00:00','20:00:00'=>'20:00:00','21:00:00'=>'21:00:00','22:00:00'=>'22:00:00','23:00:00'=>'23:00:00');
        $vistaAgenda=array('dayGridMonth'=>'Més','timeGridWeek'=>'Semana','timeGridDay'=>'Día','listWeek'=>'Listado');
        $tiempoVisita=['10'=>'10 minutos','20'=>'20 minutos','30'=>'30 minutos','45'=>'45 minutos','60'=>'1 hora','90'=>'1 hora y 30 minutos','120'=>'2 horas','180'=>'3 horas','240'=>'4 horas'];
        return view('empresa.configuracion',compact('configuracion','horaInicial','horaFinal','vistaAgenda','tiempoVisita'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        Configuracion::find($id)->update($request->all());
        Session::flash('mensaje','Configuraciones guardadas');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
