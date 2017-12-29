<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'capacity', 'type', 'open', 'close', 'location'
    ];

     /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'id',
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
