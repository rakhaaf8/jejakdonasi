<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'campaign_id',
        'type',
        'amount',
        'donor_name',
        'proof_of_receipt',
        'tx_hash',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
    ];

    /**
     * Relasi Belongs-To ke Campaign
     */
    public function campaign(): BelongsTo
    {
        return $this->belongsTo(Campaign::class);
    }
}