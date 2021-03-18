<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\CellCargo
 *
 * @property int $cell_cargo_id
 * @property int $cell_id
 * @property int $cargo_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|CellCargo newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CellCargo newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CellCargo query()
 * @method static \Illuminate\Database\Eloquent\Builder|CellCargo whereCargoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CellCargo whereCellCargoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CellCargo whereCellId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CellCargo whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CellCargo whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CellCargo whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class CellCargo extends Model
{
    use HasFactory;

    protected $primaryKey = "cell_cargo_id";

    protected $fillable = [
        'cell_id',
        'cargo_id',
    ];
}
