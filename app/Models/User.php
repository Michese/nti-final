<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string|null $hash
 * @method static \Illuminate\Database\Eloquent\Builder|User whereHash($value)
 * @property-read \App\Models\Role $role
 * @property int $role_id
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRoleId($value)
 * @property string $phone
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePhone($value)
 * @property string $code
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCode($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Card[] $cards
 * @property-read int|null $cards_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Order[] $clientOrders
 * @property-read int|null $client_orders_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Order[] $driverOrders
 * @property-read int|null $driver_orders_count
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'code',
        'email',
        'phone',
        'password',
    ];

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

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id', 'role_id');
    }

    public function cards()
    {
        return $this->hasMany(Card::class, 'user_id', 'id');
    }

    public function clientOrders()
    {
        return $this->hasMany(Order::class, 'client_id', 'id');
    }

    public function driverOrders()
    {
        return $this->hasMany(Order::class, 'driver_id', 'id');
    }


    public function getAllUsers() {
        return User::where('id', '!=',  1)->paginate(10);
    }

    public function getAllUsersWithoutDirectors() {
        return User::where('id', '!=',  1)
            ->where('role_id', '!=',  2)
            ->paginate(10);
    }

    public function getAllDrivers() {
        return User::where('role_id', '=', 4)
            ->get();
    }
}
