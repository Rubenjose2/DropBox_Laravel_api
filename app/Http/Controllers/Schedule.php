<?php

namespace App\Http\Controllers;

use App\Schedules;
use Illuminate\Http\Request;


class Schedule extends Controller
{
    public function index()
    {
        $data = Schedule::with(['home','opponent','seasons'])
            ->whereRaw('(group_result AND opponent_result)is NULL')
            ->take(500)
            ->get();
        return $data;
    }

    public function find($id)
    {
        $data = Schedules::find($id);

        return $data;

    }
}
