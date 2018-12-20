<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    const CREATED_AT = 'created';
    const UPDATED_AT = 'updated';

    protected $fillable = [
        'bucket',
        'content_type',
        'size',
        'name',
        'ext',
        'user',
        'media',
        'mime_type',
        'thumb_id'
    ];
    protected $table ='media';
//    public $timestamps = false;

    public function group(){
        return $this->belongsToMany('App\Group','media_relation','media_id','group_id');
    }

    protected $dateFormat = 'U';
}
