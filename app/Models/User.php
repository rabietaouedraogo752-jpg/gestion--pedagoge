<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'password',
        'role',
        'specialite',
        'telephone',
        'date_naissance',
        'adresse',
        'photo',
        'niveau'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    //elle se charge de cacher les colonnes lorsqu'on éssaie de récuperer un utilisateur
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    //un bloc pour informer qu'un étudiant(e) peut avoir plusieurs notes
    public function notes()
    {
        return $this->hasMany(\App\Models\Note::class);
    }
    public function isAdmin()
{
    // On vérifie si le rôle de l'utilisateur est bien 'admin'
    return $this->role === 'admin';
}
public function cours()
{
    return $this->hasMany(\App\Models\cour::class, 'user_id');
}

}
