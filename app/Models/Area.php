<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Area extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'area';

    protected $guarded = [];

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $model->uuid = Str::uuid();
        });
    }

    public function provinsi()
    {
        return $this->belongsTo(Provinsi::class);
    }

    public function walikota()
    {
        return $this->belongsTo(Walikota::class);
    }

    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class);
    }

    public function kelurahan()
    {
        return $this->belongsTo(Kelurahan::class);
    }

    public function pulau()
    {
        return $this->belongsTo(Pulau::class);
    }
}