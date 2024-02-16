<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Walikota extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $table = 'walikota';

    protected $guarded = [];

    public function canBeDeleted()
    {
        return !$this->provinsi && $this->unitkerja->isEmpty() && $this->seksi->isEmpty();
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

    public function provinsi()
    {
        return $this->belongsTo(Provinsi::class);
    }


}
