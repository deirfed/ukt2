<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Struktur extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'struktur';

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

    public function seksi()
    {
        return $this->belongsTo(Seksi::class);
    }

    public function tim()
    {
        return $this->belongsTo(Tim::class);
    }
}