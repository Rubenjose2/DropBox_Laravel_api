<?php

namespace App\Http\Controllers;

use App\Media;
use App\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class Groups extends Controller
{


    public function get_slug($group_id)
    {
        $slug = Group::find(['group_id',$group_id])->first();
        if($slug) {
            return response()->json(array('slug' => $slug['slug']), 200);
        }
        return response()->json(array('No Record Found'),404);

    }
    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     *
     * This function would receive the id of the group and save media data inside the media_relation
     */
    public function setMediaFiles($id,$media)
    {
//        $new_media = new Media(['name'=>'test.jpp']);//need to receive the array with values
//        $new_media->save();
        $data = Group::find($id);
        $data->media()->attach($media);

        return response()->json(array('Media files added successfully'),200);
    }
}
