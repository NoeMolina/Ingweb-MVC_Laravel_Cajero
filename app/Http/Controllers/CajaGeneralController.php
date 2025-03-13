<?php

namespace App\Http\Controllers;

use App\Models\Billete;
use App\Models\CajaGeneral;
use Illuminate\Http\Request;
use PDO;

class CajaGeneralController extends Controller
{
    public function index(){
        return view("index",);
    }

    public function verCaja(){
        $cajaGeneral = CajaGeneral::obtenerCajaGeneral(1);
        return view('verCaja', compact('cajaGeneral'));
    }

    public function abrirCaja(Request $request){
        $success = CajaGeneral::abrirCaja(1);
        if($success){
            return redirect()->route('home')->with('success', 'Transaccion realizada con exito');
        } else{
            return redirect()->route('home')->with('error','Fallo en la transaccion');
        }
        
    }

    public function agregarBilletes(Request $request){
        $success = CajaGeneral::agregarBilletes(1);
        if($success){
            return redirect()->route('home')->with('success', 'Transaccion realizada con exito');
        } else{
            return redirect()->route('home')->with('error','Fallo en la transaccion');
        }
    }

    public function canjearCheque(Request $request){
        $request->validate([
            'importe' => 'required|integer|min:1',
        ]);
        
        $importe = $request->input('importe');
        try {
            $resultado = CajaGeneral::canjearCheque($importe,1);
            return view('index', ['resultado' => $resultado]);
        } catch (\Exception $e) {
            return redirect()->route('home')->with('error', $e->getMessage());
        }

    }
}