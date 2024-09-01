<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'password',
        'rule_id',
        'header_compane_id',
    ];

    public function header_compane(){
        return $this->hasOne(HeaderCompane::class);
    }

    public function rule(){
        return $this->hasOne(Rule::class);
    }
}
