<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'sender',
        'receiver',
        'referenceID',
        'transferID',
        'amount',
        'wallet',
        'status',
        'errorMessage',
        'errorCode',
        'user_id',
        'compane_id',
        'header_compane_id',
    ];

    public function company(){
        return $this->belongsTo(Compane::class);
    }
}
