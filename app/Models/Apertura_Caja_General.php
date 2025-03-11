<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Apertura_Caja_General extends Model
{
    protected $table = "apertura_caja_general";
    protected $fillable = ["Tienda","Apertura"];
    protected $primaryKey = null;    
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;


    public static function AbrirCaja()
    {
        $status = false;
        DB::transaction(function () use (&$status) {
            $isOpen = Apertura_Caja_General::where('Tienda','=', 1)->lockForUpdate()->first();
            if ($isOpen && $isOpen->Apertura == 0) {
                $isOpen->Apertura = 1;
                $isOpen->save(); // Llamada al método save en la instancia del modelo
                $status = true;
            }
        });
        return $status;
    }
}