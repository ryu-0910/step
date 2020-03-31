<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Step extends Model
{   
    protected $fillable = [
        'title', 'content','img','time','category_id'
    ]; 

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function childSteps()
    {
        return $this->hasMany('App\ChildStep');
    }

    public function category()
    {
        return $this->belongsTo('App\Category');
        
    }

    public function challenges()
    {
        return $this->hasMany('App\Challenge');
    }
}
