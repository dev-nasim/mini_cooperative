<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transection extends Model
{
    use HasFactory;
    protected $dates = ['transaction_date'];
    public function member()
    {
        return $this->belongsTo(Member::class);
    }
    public function group()
    {
        return $this->belongsTo(Group::class, 'group_id');
    }
}
