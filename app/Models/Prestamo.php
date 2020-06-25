<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prestamo extends Model
{
    protected $fillable = [
        'client_id',
        'cantidad',
        'noPagos',
        'cuota',
        'totalPagar',
        'fechaMinistracion',
        'fechaVencimiento'
    ];

    protected $appends = [
        'pagos_realizados',
        'prestamo_abonado',
        'prestamo_restante',
    ];

    public function client()
    {
        return $this->belongsTo('App\Models\Client');
    }

    public function pagos()
    {
        return $this->hasMany('App\Models\Pago')->orderBy('number');
    }

    public function getPagosRealizadosAttribute()
    {
        return $this->pagos()->where('abono','>',0)->count();
    }

    public function getPrestamoAbonadoAttribute()
    {
        return $this->pagos()->sum('abono');
    }

    public function getPrestamoRestanteAttribute()
    {
        $Total = $this->pagos()->sum('cantidad');
        $Resta = $Total - $this->PrestamoAbonado;
        return $Resta;
    }
}
