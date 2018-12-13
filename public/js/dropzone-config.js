var token =  $('#csrf_token').attr('value');
var total_photo_counter = 0;
var bulksize = 0;

//This function would convert the size to the conventional name size

function bytesToSize(bytes) {
    var sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
    if (bytes == 0) return '0 Byte';
    var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
    return Math.round(bytes / Math.pow(1024, i), 2) + ' ' + sizes[i];
};


Dropzone.options.myDropzone= {
    // url: "upload/dropzone",//used to put in dropbox
    url:"./upload/dropzone",
    maxFiles:30,
    timeout:180000,
    parallelUploads:1,
    acceptedFiles: 'image/*',
    addRemoveLinks: true,
    autoProcessQueue:false,
    chunking:true,
    forceChunking:true,
    chunkSize:256000,
    parallelChunkUploads:false,
    retryChunks:false,
    retryChunksLimit:3,

    init: function ()
    {
        myDropzone = this;
        $('#submit-all').on("click",function(e)
        {
            e.preventDefault();
            e.stopPropagation();
            myDropzone.processQueue();
        });

        this.on("addedfile",function(file){
            //Adding the number of files to be added into the upload
            total_photo_counter++;
            $("#counter").text(total_photo_counter);

            //Showing the total amount of MB in the bulk process
            bulksize = bulksize + file.size;
            $("#bulk_size").text(bytesToSize(bulksize));

            //This would enable the button in order to submit the pictures
            $('#submit-all').removeClass('disabled');


        })
        this.on("sending",function (file,xhr,formData) {
            formData.append('school_name',jQuery('#school').val());
            formData.append("_token", token);
            formData.append("filezzide",file.size);

        });
        this.on("success",function()
        {
            myDropzone.options.autoProcessQueue = true;
        });

        this.on("complete",function(file)
        {
            // myDropzone.removeFile(file);
        })

        this.on("totaluploadprogress",function(totalPercentage)
        {
            if(totalPercentage){
                $("#myprogressbar").css('width',totalPercentage +'%');
            }

        })
    }
};








// Dropzone.options.myDropzone ={
//     url:"upload/dropzone",
//     uploadMultiple: true,
//     paramName:"file",
//     params:{
//       _token:token
//     },
//
// };

// var request =  new XMLHttpRequest();
// form = document.querySelector('form');
// $('#submit-all').on("click",function(e)
// {
//     e.preventDefault();
//     var formdata = new FormData(form);
//     request.open('post','upload/dropzone');
//     request.send(formdata);
// });


// var baseUrl = "/upload/dropzone";
// var token =  $('#csrf_token').attr('value');
//
// Dropzone.autoDiscover = false;
// var myDropzone = new Dropzone("div#myDropzone",
//     {
//         url:baseUrl,
//         paramName:"File",
//         addRemoveLinks:true,
//         autoProcessQueue:false,
//         uploadMultiple:true,
//         parallelUploads:10,
//         acceptedFiles: 'image/*',
//         params:
//             {
//                 _token: token
//             },
//         init: function()
//         {
//             dzClosure = this;
//
//             $('#submit-all').on("click",function(e)
//             {
//                 e.preventDefault();
//                 dzClosure.processQueue();
//             })
//         }
//     });



// Dropzone.options.myDropzone = {
//
//     paramName: "file", // The name that will be used to transfer the file
//     addRemoveLinks: true,
//     autoProcessQueue: false,
//     uploadMultiple: true,
//     acceptedFiles: 'image/*',
//     accept: function(file, done) {
//
//     },
// };


