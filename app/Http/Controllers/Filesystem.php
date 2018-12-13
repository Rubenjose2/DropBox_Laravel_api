<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Pion\Laravel\ChunkUpload\Exceptions\UploadMissingFileException;
use Pion\Laravel\ChunkUpload\Handler\AbstractHandler;
use Pion\Laravel\ChunkUpload\Handler\HandlerFactory;
use Pion\Laravel\ChunkUpload\Receiver\FileReceiver;
use Intervention\Image\Facades\Image;



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

//        //Getting the schedule information from the School
//        $school = $request->get('school');
//
//        // File construction information//
//
//        $upload_file = $request->file('file');
//        $file_name= $this->createFilename($upload_file);
//
//        //Thumbnail construction
//
//        $thumbnail = $this->small_picture($upload_file);
//        $thumbnail_file = $thumbnail['content'];
//        $thumbnail_uri = $thumbnail['url'];
//
//
//        //Saving the Temp Thumbnail file into dropbox
//        Storage::disk('dropbox')->putFileAs("2018-2019/".$school,new File($thumbnail_uri),"thum_".$file_name);
//
//        //Destroying the temporary file thumbnail
//        $thumbnail_file->destroy();
//        unlink($thumbnail_uri);
//
//        //Saving the full resolution if the image
//        Storage::disk('dropbox')->putFileAs("2018-2019/".$school,$upload_file,$file_name);
//
//
//        return response()->json($thumbnail_uri);
//
//


        $temp_folder = public_path('temp/');
        $resize = Image::make(imagecreatefromjpeg($temp_folder.'IMG_1448_eaa3b82732cd8c8f2d3c52a7c0fd1400.jpg'));
        $resize->resize(300,null,function($constraint)
        {
            $constraint->aspectRatio();
        });
        $resize->encode('jpg');


        //Here we are collecting and adding the Watermark image
        $watermark = Image::make(public_path('storage/watermark/my_gsnp_watermark.png'));
        $resize->insert($watermark,'center');


        //Collecting original name and url of the image saved temp in the server
        $thumbnail_image_name = 'thum_IMG_1448_eaa3b82732cd8c8f2d3c52a7c0fd1400.jpg';
        $resize->save($temp_folder.$thumbnail_image_name);
        $saved_image_uri = $resize->dirname."/".$resize->basename;

        //Sending back the content and the url of the thumbnail
        return $saved_image_uri;



    }



    public function gg_file_upload( Request $request)
    {
        $school = $request->get('school');
        $upload_file = $request->file('file');
        $file_name = $upload_file->getClientOriginalName();
        Storage::disk('gcs')->putFileAs("2018-2019/".$school,$upload_file,$file_name);
        print_r($file_name);
    }

    public function dropzone(Request $request)
    {

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

    public function gg_dropzone(Request $request)
    {
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
            return $this->saveFiletoGGC($save->getFile());
        }

        //Because we are on chunk mode we need to send the status
        //

        $handler = $save->handler();

        return response() ->json([
            "done"=> $handler->getPercentageDone(),
            'status' => true
        ]);
    }

    //This function is saving the File LOCAL if is needed
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

        //Selecting the type of Disk
        $disk = Storage::disk('dropbox');

        //Composing the fine name
        $filename = $this->createFilename($file);

        //Here we are saving the file inside the Drop_box
        $disk->putFileAs('demo',$file,$filename);

        //Thumbnail construction

        $thumbnail = $this->small_picture($file,$filename);
        $thumbnail_file = $thumbnail['content'];
        $thumbnail_uri = $thumbnail['url'];

        //Saving the Temp Thumbnail file into drop_box

        $disk->putFileAs("demo",new File($thumbnail_uri),"thum_".$filename);



        //We need to unlink the file when uploaded to dropbox
//        unlink($file->getPathname());
//        $thumbnail_file->destroy();
//        unlink($thumbnail_uri);


        return response()->json([
       'name'=>$filename
    ]);
    }

    protected function saveFiletoGGC($file)
    {
        $filename = $this->createFilename($file);

        $disk = Storage::disk('gcs');
        //Here we are saving the file inside the Drop_box
        $disk->putFileAs('/',$file,$filename,'public');

        //We need to unlink the file when uploaded to dropbox
        unlink($file->getPathname());

        return response()->json([
            'name'=>$filename
        ]);
    }
    protected function small_picture($file,$filename)
        /** This private function would create a small version of the File
         *  and add the water mark to it.
         * The resolution of the file would be set to 300 px constraint .
         * @Param is the input file.
         * @Return is the content file and the url where the picture is saved inside the local server
         */

    {
        //need to create a temporary file locally to manipulate it and make it thumbnail

        $temp_folder = public_path('temp/');
        $file->move($temp_folder,$filename);

        //refactoring the image

        $resize = Image::make(imagecreatefromjpeg($temp_folder.$filename));
        dd($resize);

        $resize->resize(300,null,function($constraint)
        {
            $constraint->aspectRatio();
        });
        $resize->encode('jpg');


        //Here we are collecting and adding the Watermark image
        $watermark = Image::make(public_path('storage/watermark/my_gsnp_watermark.png'));
        $resize->insert($watermark,'center');

        //Collecting original name and url of the image saved temp in the server
        $thumbnail_image_name = $file->getClientOriginalName();
        $resize->save('storage/'.$thumbnail_image_name);
        $saved_image_uri = $resize->dirname."/".$resize->basename;

        //Sending back the content and the url of the thumbnail
        return array('content'=>$resize,'url' => $saved_image_uri);
    }
}
