<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\CargoOrder
 *
 * @property int $id
 * @property int $order_id
 * @property int $cargo_id
 * @property int $hasShip
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Cargo $cargo
 * @property-read \App\Models\Order $order
 * @method static \Illuminate\Database\Eloquent\Builder|CargoOrder newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CargoOrder newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CargoOrder query()
 * @method static \Illuminate\Database\Eloquent\Builder|CargoOrder whereCargoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CargoOrder whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CargoOrder whereHasShip($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CargoOrder whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CargoOrder whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CargoOrder whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class CargoOrder extends Model
{
    use HasFactory;
    protected $table = "cargo_orders";
    protected $primaryKey = "id";
    protected $fillable = [
        "order_id",
        "cargo_id"
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'order_id');
    }

    public function cargo()
    {
        return $this->belongsTo(Cargo::class, 'cargo_id', 'cargo_id');
    }
}
