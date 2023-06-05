<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskModel extends Model
{
    use HasFactory;

    protected $table = "todolist";
    protected $primaryKey = "ID";

    protected $fillable =[
        'Task',
    ];

    public function setTaskAttribute($value)
{
    $this->attributes['Task'] = ucfirst(strtolower($value));
}

}
