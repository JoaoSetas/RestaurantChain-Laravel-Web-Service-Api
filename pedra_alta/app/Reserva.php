<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'number', 'date', 'restaurante_id'
    ];

    /**
     * Menu de um Restaurante
     *
     * @return Retorna como objecto a tabela do menu deste restaurante
     */
    public function restaurante(){
        return $this->belongsTo('App\Restaurante');
    }
}
