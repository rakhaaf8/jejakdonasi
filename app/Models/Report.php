<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    // Mengizinkan form untuk mengisi kolom-kolom ini
    protected $fillable = [
        'campaign_id',
        'name',
        'email',
        'description',
        'status',
    ];

    // Relasi: Satu laporan dimiliki oleh satu kampanye
    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }
}