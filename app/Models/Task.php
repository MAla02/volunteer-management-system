<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    // التعديل هنا: أضفنا description للمصفوفة
    protected $fillable = ['name', 'description'];

    public function assignments() {
        return $this->hasMany(Assignment::class);
    }
}