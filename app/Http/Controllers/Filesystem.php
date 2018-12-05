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

    public function file_upload(Request $request)
    {
        $school = $request->get('school');
        $upload_file = $request->file('file');
        $file_name = $upload_file->getClientOriginalName();
        Storage::disk('dropbox')->putFileAs("2018-2019/".$school,$upload_file,$file_name);

        print_r($file_name);
    }

    public function dropzone(Request $request)
    {

    }

}
