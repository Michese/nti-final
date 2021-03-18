<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\EmployeeWarehouse
 *
 * @property int $employee_warehouse_id
 * @property int $user_id
 * @property int $warehouse_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeWarehouse newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeWarehouse newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeWarehouse query()
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeWarehouse whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeWarehouse whereEmployeeWarehouseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeWarehouse whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeWarehouse whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeWarehouse whereWarehouseId($value)
 * @mixin \Eloquent
 */
class EmployeeWarehouse extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'warehouse_id'
    ];
}
