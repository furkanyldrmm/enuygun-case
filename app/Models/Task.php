<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $appends = ['unit_work','const_dev_id'];

    public function getUnitWorkAttribute(): float|int
    {
        return $this->time * $this->difficulty;
    }
}
