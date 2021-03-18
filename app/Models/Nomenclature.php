<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Nomenclature
 *
 * @property int $nomenclature_id
 * @property string $number
 * @property string $body
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Nomenclature newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Nomenclature newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Nomenclature query()
 * @method static \Illuminate\Database\Eloquent\Builder|Nomenclature whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Nomenclature whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Nomenclature whereNomenclatureId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Nomenclature whereNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Nomenclature whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Cargo[] $cargos
 * @property-read int|null $cargos_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Card[] $cards
 * @property-read int|null $cards_count
 */
class Nomenclature extends Model
{
    use HasFactory;

    protected $table = "nomenclatures";
    protected $primaryKey = "nomenclature_id";
    protected $fillable = [
        "number",
        "body"
    ];

    public function cargos()
    {
        return $this->hasMany(Cargo::class, 'nomenclature_id', 'nomenclature_id');
    }

    public function cards()
    {
        return $this->hasMany(Card::class, 'card_id', 'card_id');
    }

    public function getAllNomenclatures()
    {
        return Nomenclature::paginate(10);
    }



}
