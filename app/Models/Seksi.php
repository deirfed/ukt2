<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Seksi extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $table = 'seksi';

    protected $guarded = [];

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $model->uuid = Str::uuid();
        });
    }

    public function unitkerja()
    {
        return $this->belongsTo(UnitKerja::class);
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
