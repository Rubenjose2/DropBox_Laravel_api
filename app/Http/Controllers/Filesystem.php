<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Pion\Laravel\ChunkUpload\Exceptions\UploadMissingFileException;
use Pion\Laravel\ChunkUpload\Handler\AbstractHandler;
use Pion\Laravel\ChunkUpload\Handler\HandlerFactory;
use Pion\Laravel\ChunkUpload\Receiver\FileReceiver;


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
//
//        $files = $request->file('file');
        $dir = public_path().('/upload/');
//
//        foreach ($files as $file ){
//            $filename = $file->getClientOriginalName();
//            $file->move($dir,$filename);
//
//        }
        //Create the file receiver
        $receiver = new FileReceiver("file",$request,HandlerFactory::classFromRequest($request));

        //Check if the upload is success , throw exception or return response you need
        if($receiver->isUploaded()=== false){
            throw new UploadMissingFileException();
        }

        //receive the file

        $save  = $receiver->receive();

        //Check if the upload has finished
        if ($save->isFinished())
        {
            //save the file and return any response
            return $this->saveFiletoDropbox($save->getFile());
        }

        //Because we are on chunk mode we need to send the status
        //

        $handler = $save->handler();

        return response() ->json([
            "done"=> $handler->getPercentageDone(),
            'status' => true
        ]);

    }

    protected function saveFile(UploadedFile $file)
    {
        $fileName = $this->createFilename($file);
        // Group files by mime type
        $mime = str_replace('/', '-', $file->getMimeType());
        // Group files by the date (week
        $dateFolder = date("Y-m-W");
        // Build the file path
//        $filePath = "upload/{$mime}/{$dateFolder}/";
//        $finalPath = storage_path("app/".$filePath);
        $finalPath = public_path().('/upload/');
        // move the file name
        $file->move($finalPath, $fileName);
        return response()->json([
            'name' => $fileName,
            'mime_type' => $mime
        ]);
    }
    /**
     * Create unique filename for uploaded file
     * @param UploadedFile $file
     * @return string
     */
    protected function createFilename(UploadedFile $file)
    {
        $extension = $file->getClientOriginalExtension();
        $filename = str_replace(".".$extension, "", $file->getClientOriginalName()); // Filename without extension
        // Add timestamp hash to name of the file
        $filename .= "_" . md5(time()) . "." . $extension;
        return $filename;
    }

    protected function saveFiletoDropbox($file)
    {
        $filename = $this->createFilename($file);

        $disk = Storage::disk('dropbox');
        //Here we are saving the file inside the Drop_box
        $disk->putFileAs('demo',$file,$filename);

        //We need to unlink the file when uploaded to dropbox
        unlink($file->getPathname());

        return response()->json([
       'name'=>$filename
    ]);
    }

}
