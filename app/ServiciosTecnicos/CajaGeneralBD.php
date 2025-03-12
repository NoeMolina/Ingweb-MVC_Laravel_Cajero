<?php

namespace app\ServiciosTecnicos;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CajaGeneralBD extends Model{
    protected $table = "caja_general";
    protected $primaryKey = 'Denominacion';
    protected $fillable = ['Tienda', 'Denominacion', 'cant_disponible'];
    public $incrementing = false;
    protected $keyType = 'int';
    public $timestamps = false;
    
    public $contCaja;

    public static function ObtenerCajaGeneral($Tienda){
        try {
            DB::beginTransaction();
            // Utiliza Eloquent para obtener instancias del modelo CajaGeneralBD
            $contCaja = CajaGeneralBD::where('Tienda', '=', $Tienda)->orderBy('Denominacion', 'desc')->lockForUpdate()->get();
            return $contCaja;
            } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public static function guardarObjeto($Caja){
        try {
        foreach ($Caja as $money) {
            $money->save();
        }
        self::allOK();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    private static function allOK(){
        DB::commit();
    }
    public static function BAD(){
        DB::rollBack();
    }

}