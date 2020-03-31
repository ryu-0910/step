<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChildStep extends Model
{   
    protected $fillable = [
        'title', 'content', 'time', 'num'
    ];

    public function step()
    {
        return $this->belongsTo('App\Step');
    }
    public function clears()
    {
        return $this->hasMany('App\Clear');
    }
}
