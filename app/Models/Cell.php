<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Cell
 *
 * @property int $cell_id
 * @property int $row
 * @property int $column
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $warehouse_id
 * @method static \Illuminate\Database\Eloquent\Builder|Cell newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Cell newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Cell query()
 * @method static \Illuminate\Database\Eloquent\Builder|Cell whereCellId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cell whereColumn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cell whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cell whereRow($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cell whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cell whereWarehouseId($value)
 * @mixin \Eloquent
 */
class Cell extends Model
{
    use HasFactory;

    protected $table = "cells";
    protected $primaryKey = "cell_id";
    protected $fillable = [
        "warehouse_id",
        "row",
        "column"
    ];
}
