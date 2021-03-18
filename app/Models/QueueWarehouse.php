<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\QueueWarehouse
 *
 * @property int $queue_warehouse_id
 * @property int $order_id
 * @property int $warehouse_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|QueueWarehouse newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|QueueWarehouse newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|QueueWarehouse query()
 * @method static \Illuminate\Database\Eloquent\Builder|QueueWarehouse whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QueueWarehouse whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QueueWarehouse whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QueueWarehouse whereQueueWarehouseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QueueWarehouse whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QueueWarehouse whereWarehouseId($value)
 * @mixin \Eloquent
 */
class QueueWarehouse extends Model
{
    use HasFactory;
    protected $primaryKey = "queue_warehouse_id";
    protected $fillable = [
        'order_id',
        'warehouse_id'
    ];
}
