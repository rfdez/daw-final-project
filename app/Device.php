<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'serial', 'name', 'model'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime:d/m/Y H:i:s',
        'updated_at' => 'datetime:d/m/Y H:i:s',
    ];

    //Grupo al que pertenece el dispositivo
    public function groups()
    {
        return $this->belongsToMany('App\Group');
    }

    //Valores del dispositivo
    public function values()
    {
        return $this->hasMany('App\Value');
    }

    //Localizaciones que se observan del dispositivo
    public function locations()
    {
        return $this->hasMany('App\Location');
    }

    //Reglas opcionales que el usuario puede imponer a los valores del dispositivo
    public function rules()
    {
        return $this->hasMany('App\Rule');
    }

    //Alertas que generan la regla
    public function alerts()
    {
        return $this->hasMany('App\Alert');
    }
}
