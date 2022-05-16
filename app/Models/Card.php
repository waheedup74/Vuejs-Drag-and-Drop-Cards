<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    use HasFactory;
    protected $fillable = [
        'id', 'title','order', 'column_id',
    ];

     public function columns()
    {
        return $this->belongsTo(Column::class, 'column_id');
    }
}
