<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prestamo;
use App\Models\Client;
use App\Models\Pago;
use Carbon\Carbon;
Use Session;

class PrestamosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $prestamos = Prestamo::with('client')->get();
        return response()->json($prestamos);
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
        $request->validate([
            'client_id'  => 'required',
            'cantidad' => 'required',
            'noPagos' => 'required',
            'cuota' => 'required',
            //'fechaMinistracion' => 'required',
            //'fechaVencimiento' => 'required',
        ]);

        $date = Carbon::now();

        $n = $request->input('noPagos');
        $m = $request->input('cuota');
        $datefinish = Carbon::now();
        $j = 1;
        $dateAdd = $datefinish->addDay();  //Sumamos un dia al actual
        do
        {
            $Day = $dateAdd->dayOfWeek;    //Obtenemos el dia de semana
            if($Day == 6)
            {
                $dateAdd = $datefinish->addDays(2);
            }
            else if($Day == 0)
            {
                $dateAdd = $datefinish->addDay();
            }
            else
            {
                $j++;
                $dateAdd = $datefinish->addDay();
            }
        }while($j<$n);

        $DayFinish = $dateAdd->dayOfWeek;
        if($DayFinish == 6)
        $dateAdd = $datefinish->addDays(2);

        $prestamo = new Prestamo();
        $prestamo->client_id = $request->input('client_id');
        $prestamo->cantidad = $request->input('cantidad');
        $prestamo->noPagos = $request->input('noPagos');
        $prestamo->cuota = $request->input('cuota');
        $prestamo->totalPagar = $n*$m;
        $prestamo->fechaMinistracion = $date;
        $prestamo->fechaVencimiento = $dateAdd;
        $prestamo->save();

        $i = 1;
        do
        {   
            $dayNext = $date->addDay();
            $dateDay = $dayNext->dayOfWeek;
            if($dateDay != 0 && $dateDay != 6)
            {
                $pagos = new Pago();
                $pagos->prestamo_id = $prestamo->id;
                $pagos->number = $i;
                $pagos->cantidad = $request->input('cuota');
                $pagos->fechaPago = $dayNext;
                $pagos->abono = ('0');
                $pagos->save();
                $i++;
            }
        } while($i<=$n);

        return response()->json(true);
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $prestamo = Prestamo::findOrFail($id);
        foreach ($prestamo->pagos as $pago)
        {
            $pago->delete();
        }
        $prestamo->delete();
        
        return $prestamo;
    }

    public function select()
    {
        $nombres = Client::select('id','name')->get();
        return response()->json($nombres);
    }
}
