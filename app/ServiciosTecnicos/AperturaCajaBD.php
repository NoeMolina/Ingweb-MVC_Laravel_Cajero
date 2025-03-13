<?php
namespace App\ServiciosTecnicos;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AperturaCajaBD extends Model
{
    protected $table = "apertura_caja_general";
    protected $fillable = ["Tienda","Apertura"];
    protected $primaryKey = 'Tienda';    
    public $incrementing = false;
    public $timestamps = false;


    public static function getCajaGeneral($tienda)
    {
        try {
            DB::beginTransaction();
            $contCaja = AperturaCajaBD::where('Tienda', '=', $tienda)->lockForUpdate()->first();
            return $contCaja;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
    public static function guardarObjeto($Caja){
        try {
            $Caja->save();
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