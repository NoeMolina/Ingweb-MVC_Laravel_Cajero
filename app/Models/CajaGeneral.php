<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use App\Models\Apertura_Caja_General;
use App\ServiciosTecnicos\CajaGeneralBD;
use Illuminate\Database\Eloquent\Model;

class CajaGeneral extends Model
{
    protected $table = "caja_general";
    protected $fillable = ["valor", "cantidad"];
    protected $primaryKey = null;
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    public static function ContenidoCaja()
    {
        $contenidoCaja = CajaGeneralBD::all();

        return $contenidoCaja;
    }

    public static function abrirCaja($Tienda)
    {
        // Verificamos si la caja puede ser abierta
        if (!Apertura_Caja_General::AbrirCaja()) {
            return false;
        }

        $contCaja = CajaGeneralBD::ObtenerCajaGeneral($Tienda);
        foreach ($contCaja as $money) {
            //dd($money->cant_disponible);
            $cantAgregar = rand(10, 50);
            $money->cant_disponible += $cantAgregar;
        }

        // Actualizamos las denominaciones en la base de datos usando Eloquent y el método save()
        if (CajaGeneralBD::guardarObjeto($contCaja)) {
            return true;
        } else {
            return false;
        }
    }

    public static function agregarBilletes($Tienda)
    {
        $contCaja = CajaGeneralBD::ObtenerCajaGeneral($Tienda);
        foreach ($contCaja as $money) {
            //dd($money->cant_disponible);
            $cantAgregar = rand(10, 50);
            $money->cant_disponible += $cantAgregar;
        }

        // Actualizamos las denominaciones en la base de datos usando Eloquent y el método save()
        if (CajaGeneralBD::guardarObjeto($contCaja)) {
            return true;
        } else {
            return false;
        }
    }

    public static function canjearCheque($importe, $Tienda)
    {
        $resultado = [];
        $contCaja = CajaGeneralBD::ObtenerCajaGeneral($Tienda);
        foreach ($contCaja as $money) {
            if ($importe <= 0) break;
            $denominacion = $money->Denominacion;
            $cantidadNecesaria = intdiv($importe, $denominacion); // Número de billetes a retirar
            $cantidadDisponible = $money->cant_disponible;
            // Calcular cuántos billetes retirar
            $aRetirar = min($cantidadNecesaria, $cantidadDisponible);

            // Restar el importe correspondiente
            $importe -= $aRetirar * $denominacion;
            $money->cant_disponible -= $aRetirar;
            $money->cant_retirada += $aRetirar;

            if ($aRetirar > 0) {
                $resultado[] = [
                    'denominacion' => $denominacion,
                    'cantidad' => $aRetirar
                ];
            }
        }
        if ($importe > 0) {
            CajaGeneralBD::BAD();
            throw new \Exception("Fondos insuficientes en caja para canjear el cheque.");
        }
        CajaGeneralBD::guardarObjeto($contCaja);
        return $resultado;
    }
    public static function obtenerCajaGeneral($Tienda)
    {
        $contCaja = CajaGeneralBD::ObtenerCajaGeneral($Tienda);
        return $contCaja;
    }
}
