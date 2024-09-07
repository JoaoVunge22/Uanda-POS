<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HeaderCompane extends Model
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
        'user_id'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function company(){
        return $this->hasMany(Compane::class);
    }

    public function transaction(){
        return $this->hasMany(Transaction::class);
    }

}
