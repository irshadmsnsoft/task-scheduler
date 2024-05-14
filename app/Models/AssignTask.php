<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignTask extends Model
{
    use HasFactory;
    protected $table = 'assign_tasks';
    protected $fillable = [
        'user_id',
        'task_id',
        'status',
        'comment',
    ];
    public function task()
{
    return $this->belongsTo(Task::class, 'task_id', 'id');
}
}