<?php

namespace App\Http\Controllers;

use App\Media;
use App\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class Groups extends Controller
{


    public function index()
    {
        DB::enableQueryLog();
        $data = Group::all();
        dd(DB::getQueryLog());
        return $data;
    }

    public function get_slug($group_id)
    {
        $slug = Group::find([$group_id])->first();
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
    public function setMediaFiles($id,$media,$events_id = null)
    {
        $data = Group::find($id);
        if($events_id){
            $data->media()->attach($media,['events_id'=> $events_id]);
        }else{
            $data->media()->attach($media);
        }
        return response()->json(array('Media files added successfully'),200);
    }
}
