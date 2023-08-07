<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Bavix\Wallet\Interfaces\Customer;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];





    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    |
    | Here is where you can define all of the relationships for the model.
    |
    */


    public function wallet()
    {
        return $this->morphOne(Wallet::class, 'owner');
    }


    /*
    |--------------------------------------------------------------------------
    | Methods
    |--------------------------------------------------------------------------
    |
    | Here is where you can define all of the methods for the model.
    |
    */


    public function liked_doctors()
    {
        return $this->hasMany(UserLikedDoctor::class);
    }


    public function has_liked(Doctor $doctor)
    {
        return $this->liked_doctors()->where('doctor_id', $doctor->id)->exists();
    }

    public function like(Doctor $doctor)
    {
        $this->liked_doctors()->create([
            'doctor_id' => $doctor->id
        ]);
    }

    public function unlike(Doctor $doctor)
    {
        $this->liked_doctors()->where('doctor_id', $doctor->id)->delete();
    }
}
