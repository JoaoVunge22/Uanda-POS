<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compane extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'wallet',
        'header_compane_id',
        'user_id'
    ];

    protected function casts(): array
    {
        return [
            'wallet' => 'array',
        ];
    }

    public function transaction(){
        return $this->hasMany(Transaction::class);
    }

    public function header_compane(){
        return $this->belongsTo(HeaderCompane::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
