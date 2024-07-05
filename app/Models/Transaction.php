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
        'userID',
        'walletID',
        'status',
        'errorMessage',
        'errorCode',
        'compane_id',
    ];

    public function company(){
        return $this->hasOne(Company::class);
    }
}
