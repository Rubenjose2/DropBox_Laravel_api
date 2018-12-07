var token =  $('#csrf_token').attr('value');

Dropzone.options.myDropzone= {
    url: "upload/dropzone",
    timeout:180000,
    parallelUploads:1,
    acceptedFiles: 'image/*',
    addRemoveLinks: true,
    autoProcessQueue:false,
    chunking:true,
    forceChunking:true,
    chunkSize:256000,
    parallelChunkUploads:true,
    retryChunks:true,
    retryChunksLimit:3,

    init: function ()
    {
        myDropzone = this;
        $('#submit-all').on("click",function(e)
        {
            e.preventDefault();
            e.stopPropagation();
            myDropzone.processQueue();
        })
        this.on("sending",function (file,xhr,formData) {
            formData.append('school_name',jQuery('#school').val());
            formData.append("_token", token);
            formData.append("filezzide",file.size);

        })
        this.on("success",function()
        {
            myDropzone.options.autoProcessQueue = true;
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


