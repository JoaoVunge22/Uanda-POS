<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    use HasFactory;

    protected $fillable = [
        'name','status','image'
    ];

    protected function casts(): array
    {
        return [
            // 'rule' => 'array',
        ];
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
