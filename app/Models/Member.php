<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    public function cooperative()
    {
        return $this->belongsTo(Cooperative::class, 'coop_id', 'id');
    }
    public function group()
    {
        return $this->belongsTo(Group::class, 'group_id', 'id');
    }
}
