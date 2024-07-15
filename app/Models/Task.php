<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Date;

/**
 * Summary of Task
 * @property int $id
 * @property string $title
 * @property string $description
 * @property string $status
 * @property string $due_date
 */
class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        "title",
        "description",
        "status",
        "due_date"
    ];
}
