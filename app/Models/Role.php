<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Role
 *
 * @property int $role_id
 * @property string $title
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $role
 * @method static \Illuminate\Database\Eloquent\Builder|Role newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Role newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Role query()
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereRoleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $user
 * @property-read int|null $user_count
 */
class Role extends Model
{
    use HasFactory;

    protected $table = "roles";
    protected $primaryKey = "role_id";
    protected $fillable = [
      "title"
    ];

    public function user()
    {
        return $this->hasMany(User::class, 'role_id','role_id');
    }

    public function getAllRoles()
    {
        return Role::where('role_id', '!=', 1)->get();
    }

    public function getAllRolesWithoutDirector()
    {
        return Role::where('role_id', '!=', 1)
            ->Where('role_id', '!=', 2)
            ->get();
    }
}
