<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Order
 *
 * @property int $order_id
 * @property string $document
 * @property int $client_id
 * @property int $driver_id
 * @property int $status_id
 * @property string|null $completion
 * @method static \Illuminate\Database\Eloquent\Builder|Order newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Order newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Order query()
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereClientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereCompletion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereDocument($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereDriverId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereStatusId($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\CargoOrder[] $cargos
 * @property-read int|null $cargos_count
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $arrival_at
 * @property-read \App\Models\User $client
 * @property-read \App\Models\User $driver
 * @property-read \App\Models\Status $status
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereArrivalAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereUpdatedAt($value)
 */
class Order extends Model
{
    use HasFactory;

    protected $table='orders';
    protected $primaryKey = 'order_id';

    protected $fillable = [
        'document',
        'client_id',
        'driver_id',
    ];

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id', 'id');
    }

    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id', 'status_id');
    }

    public function driver()
    {
        return $this->belongsTo(User::class, 'driver_id', 'id');
    }

    public function cargos()
    {
        return $this->hasMany(CargoOrder::class, 'order_id', 'order_id');
    }
}
