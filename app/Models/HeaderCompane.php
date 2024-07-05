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
    ];

    public function Compone(){
        return $this->belongsTo(Compane::class);
    }

}
