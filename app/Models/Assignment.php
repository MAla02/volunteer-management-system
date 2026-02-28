<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    use HasFactory;

    // الحقول المسموح بتعبئتها فقط للسبرنت الحالي
    protected $fillable = [
        'volunteer_id',
        'location_id',
        'task_id',
        'assigned_date',
        // حذفنا status لأنه يتبع لـ Story #14 في الـ To Do
    ];

    // علاقة التكليف مع المتطوع (ضرورية لـ Story #5)
    public function volunteer() {
        return $this->belongsTo(Volunteer::class);
    }

    // علاقة التكليف مع الموقع (ضرورية لـ Story #13 - Logistics)
    public function location() {
        return $this->belongsTo(Location::class);
    }

    // علاقة التكليف مع المهمة (ضرورية لـ Story #12 - View Tasks)
    public function task() {
        return $this->belongsTo(Task::class);
    }
}