<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description'
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

    //Usuarios que pertenecen al grupo
    public function users()
    {
        return $this->belongsToMany('App\User')->withPivot('owner');
    }

    //Dispositivos asociados a el grupo
    public function devices()
    {
        return $this->belongsToMany('App\Device');
    }
}
