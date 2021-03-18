<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Cargo
 *
 * @property int $cargo_id
 * @property int $nomenclature_id
 * @property string $barcode
 * @property float $weight
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Cargo newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Cargo newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Cargo query()
 * @method static \Illuminate\Database\Eloquent\Builder|Cargo whereBarcode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cargo whereCargoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cargo whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cargo whereNomenclatureId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cargo whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cargo whereWeight($value)
 * @mixin \Eloquent
 * @property-read \App\Models\CargoOrder|null $cargo
 * @property-read \App\Models\Nomenclature $nomenclature
 * @property-read \App\Models\CargoOrder|null $ordered
 */
class Cargo extends Model
{
    use HasFactory;

    protected $table = "cargos";
    protected $primaryKey = "cargo_id";
    protected $fillable = [
        "nomenclature_id",
        "barcode",
        "weight"
    ];

    public function nomenclature()
    {
        return $this->belongsTo(Nomenclature::class, 'nomenclature_id', 'nomenclature_id');
    }

    public function ordered()
    {
        return $this->hasOne(CargoOrder::class, 'cargo_id', 'cargo_id');
    }
}
