<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Transport
 *
 * @property int $transport_id
 * @property int $user_id
 * @property float $capacity
 * @property float $occupancy
 * @property string $progress
 * @property int $status_id
 * @method static \Illuminate\Database\Eloquent\Builder|Transport newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Transport newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Transport query()
 * @method static \Illuminate\Database\Eloquent\Builder|Transport whereCapacity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transport whereOccupancy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transport whereProgress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transport whereStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transport whereTransportId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transport whereUserId($value)
 * @mixin \Eloquent
 */
class Transport extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "transports";
    protected $primaryKey = "transport_id";
    protected $fillable = [
        "user_id",
        "capacity"
    ];
    protected $forceDeleting = false;
}
