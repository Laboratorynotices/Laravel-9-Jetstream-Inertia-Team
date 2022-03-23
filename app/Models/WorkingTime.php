<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkingTime extends Model
{
    use HasFactory;

    /* Всегда автоматически подгружать данные пользователей,
     * чтобы их тут же передавать в вид. 
     */
    protected $with = array('user');

    /**
     * Get the user that owns the record.
     */
    public function user() {
        return $this->belongsTo(User::class);
    }
}
