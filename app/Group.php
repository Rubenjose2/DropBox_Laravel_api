<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Media;

class Group extends Model
{
    public $table = 'groups';
    public $timestamps = false;

    public function media(){
        return $this->belongsToMany(Media::class,'media_relation','group_id','media_id');
    }

    public function schedules(){
        return $this->belongsTo('App\Schedule','group_id','id');
    }
}
