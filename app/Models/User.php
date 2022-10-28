<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int    $created_at
 * @property int    $role
 * @property int    $updated_at
 * @property int    $verified_at
 * @property int    $verified_by
 * @property string $department
 * @property string $email
 * @property string $name
 * @property string $password
 * @property string $remember_token
 */
class User extends \Illuminate\Foundation\Auth\User
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'user';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'created_at', 'department', 'email', 'name', 'password', 'remember_token', 'role', 'updated_at', 'verified_at', 'verified_by'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [

    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'timestamp', 'department' => 'string', 'email' => 'string', 'name' => 'string', 'password' => 'string', 'remember_token' => 'string', 'role' => 'int', 'updated_at' => 'timestamp', 'verified_at' => 'timestamp', 'verified_by' => 'int'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'created_at', 'updated_at', 'verified_at'
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var boolean
     */
    public $timestamps = true;

    // Scopes...

    // Functions ...

    // Relations ...
}
