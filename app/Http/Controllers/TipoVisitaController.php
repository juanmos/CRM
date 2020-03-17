<?php

namespace App\Http\Controllers;

use App\Models\Plantilla;
use App\Models\TipoVisita;
use Auth;
use Illuminate\Http\Request;

class TipoVisitaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $tipos = TipoVisita::where('empresa_id', 0)
            ->orWhere('empresa_id', Auth::user()->empresa_id)
            ->orderBy('tipo')
            ->with('duracion')->get();
        if ($request->is('api/*')) {
            return response()->json(compact('tipos'));
        }
        return view('tipos.index', compact('tipos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tipoVisita        = null;
        $plantillas        = Plantilla::where('previsita', 1)->where('empresa_id', 0)->orWhere('empresa_id', Auth::user()->empresa_id)->orderBy('nombre')->get()->pluck('nombre', 'id');
        $plantillasVisitas = Plantilla::where('previsita', 0)->where('empresa_id', 0)->orWhere('empresa_id', Auth::user()->empresa_id)->orderBy('nombre')->get()->pluck('nombre', 'id');
        return view('tipos.form', compact('tipoVisita', 'plantillas', 'plantillasVisitas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data               = $request->all();
        $data['empresa_id'] = Auth::user()->empresa_id;
        TipoVisita::create($data);
        return redirect('tipoVisita');
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
        $tipoVisita        = TipoVisita::find($id);
        $plantillas        = Plantilla::where('previsita', 1)->where('empresa_id', 0)->orWhere('empresa_id', Auth::user()->empresa_id)->orderBy('nombre')->get()->pluck('nombre', 'id');
        $plantillasVisitas = Plantilla::where('previsita', 0)->where('empresa_id', 0)->orWhere('empresa_id', Auth::user()->empresa_id)->orderBy('nombre')->get()->pluck('nombre', 'id');
        return view('tipos.form', compact('tipoVisita', 'plantillas', 'plantillasVisitas'));
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
        $data = $request->all();
        $tipo = TipoVisita::find($id);
        $tipo->update($data);
        return redirect('tipoVisita');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        TipoVisita::find($id)->delete();
        return redirect('tipoVisita');
    }

    public function duracion(Request $request)
    {
        $tipo = TipoVisita::find($request->get('tipo_visita_id'));
        if ($tipo->duracion == null) {
            $tipo->duracion()->create(['empresa_id'=>auth()->user()->empresa_id, 'duracion'=>$request->get('duracion')]);
        } else {
            $tipo->duracion()->update(['duracion'=>$request->get('duracion')]);
        }
        return back();
    }
}
