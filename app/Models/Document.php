<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $fillable = [
        'nomor_dokumen',
        'judul',
        'kategori',
        'deskripsi',
        'file_url',
    ];
}
