<?php

namespace App\Models;

use App\Models\Walikota;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Provinsi extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $table = 'provinsi';

    protected $guarded = [];

    public function canBeDeleted()
    {
        return $this->walikota->isEmpty() && $this->unitkerja->isEmpty() && $this->seksi->isEmpty();
    }

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $model->uuid = Str::uuid();
        });
    }

    public function seksi()
    {
        return $this->hasMany(Seksi::class);
    }
    public function unitkerja()
    {
        return $this->hasMany(UnitKerja::class);
    }

    public function walikota()
    {
        return $this->hasMany(Walikota::class);
    }

}
