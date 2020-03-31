<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Challenge extends Model
{
    protected $fillable = [
        'step_id', 'user_id'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function step()
    {
        return $this->belongsTo('App\Step');
    }

    public function clears()
    {
        return $this->hasMany('App\Clear');
    }

}
