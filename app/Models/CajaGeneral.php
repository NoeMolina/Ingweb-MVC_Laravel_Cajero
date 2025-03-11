<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\Apertura_Caja_General;

class CajaGeneral extends Model
{
    protected $table = "caja_general";
    protected $fillable = ["valor", "cantidad"];
    protected $primaryKey = null;
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    public function ContenidoCaja()
    {
        $contenidoCaja = CajaGeneral::all();

        return $contenidoCaja;
    }

    public static function abrirCaja()
    {
        if (!Apertura_Caja_General::AbrirCaja()) {
            return false;
        }
        DB::transaction(function () {
            $cajaGeneral = CajaGeneral::where('Tienda','=', 1)->lockForUpdate()->get();
            foreach ($cajaGeneral as $caja) {
                $caja->cant_disponible = rand(10, 50);
                $caja->save();
            }
        });
        return true;
    }

    public static function agregarBilletes()
    {
        $status = false;
        DB::transaction(function () use (&$status) {
            $cajaGeneral = CajaGeneral::where('Tienda', 1)->lockForUpdate()->get();
            foreach ($cajaGeneral as $caja) {
                $caja->cant_disponible += rand(10, 50);
                $caja->save();
            }
            $status = true;
        });
        return $status;
    }

    public static function canjearCheque($importe)
    {
        $resultado = [];

        DB::transaction(function () use ($importe, &$resultado) {
            $cajaGeneral = CajaGeneral::where('Tienda', 1)
                ->lockForUpdate()
                ->orderBy('Denominacion', 'desc')
                ->get();

                $actualizaciones = [];

            foreach ($cajaGeneral as $billete) {
                if ($importe <= 0) break;

            $denominacion = $billete->Denominacion;
            $cantidadNecesaria = intdiv($importe, $denominacion); // Número de billetes a retirar
            $cantidadDisponible = $billete->cant_disponible;
            // Calcular cuántos billetes retirar
            $aRetirar = min($cantidadNecesaria, $cantidadDisponible);

            // Restar el importe correspondiente
            $importe -= $aRetirar * $denominacion;

                if ($aRetirar > 0) {
                    $resultado[] = [
                        'denominacion' => $denominacion,
                        'cantidad' => $aRetirar
                    ];

                // Acumulamos la cantidad a actualizar en el array
                if (isset($actualizaciones[$denominacion])) {
                    $actualizaciones[$denominacion] += $aRetirar;
                } else {
                    $actualizaciones[$denominacion] = $aRetirar;
                }
                }
            }
            // Ahora guardamos todos los cambios de una vez
            foreach ($actualizaciones as $denominacion => $cantidadRetirar) {
                CajaGeneral::where('Tienda', 1)
                    ->where('Denominacion', $denominacion)
                    ->decrement('cant_disponible', $cantidadRetirar); // Realizamos el decremento
            }

            if ($importe > 0) {
                throw new \Exception("Fondos insuficientes en caja para canjear el cheque.");
            }
        });

        return $resultado;
    }
}
