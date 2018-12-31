<?php

namespace App\Http\Controllers;

use App\Schedules;
use Illuminate\Http\Request;


class Schedule extends Controller
{
    public function index()
    {
        $data = Schedules::with(['home','opponent','seasons'])
            ->whereRaw('(group_result AND opponent_result)is NULL')
            ->take(500)
            ->get();
        return $data;
    }

    public function find($id)
    {
        $data = Schedules::with(['home','opponent'])
            ->where('id',$id)
            ->get();
        return $data;
    }
}
