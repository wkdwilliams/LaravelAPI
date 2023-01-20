<?php

namespace App\User\Models;

use App\Message\Models\Message;
use Lewy\DataMapper\Model;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Model implements AuthenticatableContract, AuthorizableContract, JWTSubject 
{
    use Authenticatable, Authorizable;

    protected $table = "users";

    protected $appends = [
        'messages'
    ];

    public $fillable = [
        'name',
        'email',
        'password'
    ];

    public function messages()
    {
        return $this->hasMany(Message::class);
    }
    public function getMessagesAttribute()
    {
        return $this->messages()->get();
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
