<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Objetivo;
use Auth;

class ObjetivoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $fecha)
    {
        $objetivos=auth()->user()->objetivos()->where('fecha', $fecha)->paginate(50);
        if ($request->is('api/*')) {
            return response()->json($objetivos);
        }
    }

    public function lista(Request $request)
    {
        $objetivos=auth()->user()->objetivos()->orderBy('fecha', 'desc')->paginate(50);
        if ($request->is('api/*')) {
            return response()->json($objetivos);
        }
        return view('objetivo.index', compact('objetivos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data=$request->all();
        $data['usuario_id']=Auth::user()->id;
        $objetivo = Objetivo::create($data);
        if ($request->is('api/*')) {
            return $objetivo;
        }
        return redirect()->route('objetivos.index');
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Objetivo $objetivo)
    {
        $data=$request->all();
        $objetivo->update($data);
        if ($request->is('api/*')) {
            return $objetivo;
        }
        return redirect()->route('objetivos.index');
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
