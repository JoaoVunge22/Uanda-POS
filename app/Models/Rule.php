<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rule extends Model
{
    use HasFactory;

    protected $fillable = [
        'grupo','rule','status'
    ];

    protected function casts(): array
    {
        return [
            'rule' => 'array',
        ];
    }
}
