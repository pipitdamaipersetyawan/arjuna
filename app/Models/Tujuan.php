<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tujuan extends Model
{
    protected $table = 'tujuan'; // ⬅️ TAMBAHKAN INI
    protected $fillable = ['nama'];

    public function naskah()
    {
        return $this->belongsToMany(Naskah::class);
    }
}
