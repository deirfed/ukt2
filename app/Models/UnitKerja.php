<?php

namespace App\Models;

use App\Models\Provinsi;
use App\Models\Walikota;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UnitKerja extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $table = 'unitkerja';

    protected $guarded = [];

    public function canBeDeleted()
    {
        return !$this->provinsi && !$this->walikota;
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
    public function walikota()
    {
        return $this->belongsTo(Walikota::class);
    }

    public function provinsi()
    {
        return $this->belongsTo(Provinsi::class);
    }
}
