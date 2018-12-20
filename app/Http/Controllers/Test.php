<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Test extends Controller
{
    public function __construct()
    {
        $this->groups = new Groups();
        $this->schedules = new Schedule();
        $this->media_files = new MediaFiles();
    }


    public function index()
    {
        DB::enableQueryLog();
        $data = $this->schedules->find(307299);

        $groups_ids = ['home_id' => $data['group_id'],'opponent_id'=>$data['event_opponent_id']];

        $files = $this->media_files->setMediafile();

        foreach ($groups_ids as $group_id)
        {
            $this->groups->setMediaFiles($group_id,$files);
        }

        dd(DB::getQueryLog());

        return $groups_ids;


    }
}
