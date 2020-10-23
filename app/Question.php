<?php

namespace App;

use App\User;
use Parsedown;
use App\Answer;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = ['title','body'];
    
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }
    public function getUrlAttribute()
    {
        return route("questions.show", $this->slug);
    }
    public function getCreatedDateAttribute()
    {
        return $this->created_at->diffForHumans();
    }
    public function getBodyHtmlAttribute()
    {
        return \Parsedown::instance()->text($this->body);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

}
