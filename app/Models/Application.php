<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    // الحقول المسموح بتعبئتها آلياً (Mass Assignment)
    // أضفنا الحقول الجديدة (الاسم، الهاتف، الرسالة) وحذفنا user_id مؤقتاً إذا كان التقديم للزوار فقط
    protected $fillable = ['full_name', 'email', 'phone', 'major', 'message', 'task_id', 'cv_path', 'status'];

    /**
     * بما أن الخريج زائر، علاقة الـ User ستكون اختيارية أو تعود بـ null
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * علاقة الطلب بالمهمة (الفرصة التطوعية) - ضرورية جداً ليعرف الأدمن على ماذا قدم الخريج
     */
    public function task()
    {
        return $this->belongsTo(Task::class);
    }
}