<?php

namespace App\Models;
use App\ServiciosTecnicos\AperturaCajaBD;

class Apertura_Caja_General
{
    public static function AbrirCaja($tienda)
    {
        $status = false;
        $apertura = AperturaCajaBD::getCajaGeneral($tienda);
        if ($apertura->Apertura == 0) {
            $apertura->Apertura = 1;
            try {
                AperturaCajaBD::guardarObjeto($apertura);
            } catch (\Throwable $th) {
            }
            $status = true;
        }
        return $status;
    }
}