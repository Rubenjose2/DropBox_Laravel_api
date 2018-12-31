<?php

namespace App\Http\Controllers;

use App\Group;
use App\Schedules;
use Illuminate\Http\Request;
use App\Media;
use Illuminate\Support\Facades\DB;


class MediaFiles extends Controller
{

    public function saveMediafile($media)
    {
        $new_media = new Media($media);//need to receive the array with values
        $new_media->save();

        return $new_media;
    }

}
