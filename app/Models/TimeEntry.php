<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TimeEntry extends Model
{
    protected $fillable =[
        'project_id',
        'task_id',
        'hours',
        'entry_date',
        'description'
    ];

    public function project(){
        return $this->belongsTo(Project::class);
    }
    public function Task(){
        return $this->belongsTo(Task::class);
    }

}
