<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Notifications\ResetPasswordNotification;

class User extends Authenticatable
{
    use Notifiable;

    // Usamos SoftDeletes para mantener los usuarios eliminados
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'role_id', 'foto_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    /**
     * Devuelve true si el usuario pertenece al rol de "administrador".
     * De lo contrario, devuelve false
     * 
     * @return boolean
     */
    public function esAdmin(){
        if ($this->role->nombre == 'administrador') {
            return true;
        }
        return false;
    }

    // Relación 1:1. A un usuario le pertenece un rol
    public function role()
    {
        return $this->belongsTo('App\Role');
    }

    // Relación polimórfica con el modelo Foto
    public function foto()
    {
        return $this->morphOne("App\Foto", "fotable");
    }

    // Relación 1:N - Un usuario puede escribir muchos comentarios
    public function comentarios()
    {
        return $this->hasMany('App\Comentario');
    }

    // Relación 1:N - Un usuario publica varios temas
    public function temas()
    {
        return $this->hasMany('App\Tema');
    }

    // Relación polimórfica con el modelo Like
    public function seguidores()
    {
        return $this->morphMany("App\Like", "likeable");
    }

    // Relación polimórfica con el modelo Like
    public function siguiendo()
    {
        return $this->hasMany('App\Like')->where('likeable_type', 'App\User');
    }

    // Relación 1:M con User. Un usuario tiene da muchos likes
    public function likes()
    {
        return $this->hasMany('App\Like');
    }
}
