<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compane extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'contact',
        'pais',
        'provincia',
        'cidade',
        'postal',
        'endereco',
        'wallet',
        'header_compane_id',
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

    public function users(){
        return $this->hasOne(User::class);
    }

    public function header_compane(){
        return $this->belongsTo(HeaderCompane::class);
    }
}
