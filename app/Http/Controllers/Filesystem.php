<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class Filesystem extends Controller
{
    public function index()
    {
        Storage::disk('dropbox')->makeDirectory("Baseball");
        $container = Storage::disk('dropbox')->allDirectories();

        return $container;

    }
}
