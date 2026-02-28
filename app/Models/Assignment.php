<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    // أضفنا 'status' هنا لكي يسمح لارافل بتحديثها
    protected $fillable = [
        'volunteer_id', 
        'location_id', 
        'task_id', 
        'assigned_date', 
        'status'
    ];

    public function volunteer()
    { 
        return $this->belongsTo(Volunteer::class); 
    }

    public function location() 
    { 
        return $this->belongsTo(Location::class); 
    }

    public function task()
    { 
        return $this->belongsTo(Task::class); 
    }
}