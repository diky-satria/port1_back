<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pos extends Model
{
    protected $fillable = ['judul','kategori','konten','gambar','dibuat_oleh'];
}
