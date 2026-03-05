<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Klasifikasi extends Model
{
    protected $fillable = [
        'kode',
        'nama',
        'parent_id'
    ];

    public function parent()
    {
        return $this->belongsTo(Klasifikasi::class,'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Klasifikasi::class,'parent_id')
            ->orderBy('kode');
    }
}
