// Dropzone.options
// {
//     Dropzone.autoDiscover = false;
//     $("#upload_zone").dropzone({
//         url: "/upload/dropzone",
//         autoProcessQueue: false,
//         addRemoveLinks: true,
//         acceptedFiles :'image/*',
//         init: function() {
//             var myDropzone = this;
//
//             // Here's the change from enyo's tutorial...
//
//             $("#submit-all").click(function (e) {
//                 e.preventDefault();
//                 e.stopPropagation();
//                 myDropzone.processQueue();
//             });
//         }
//     });
// })



Dropzone.options.myDropzone= {
    url: 'upload.php',
    autoProcessQueue: false,
    uploadMultiple: true,
    parallelUploads: 5,
    maxFiles: 5,
    maxFilesize: 1,
    acceptedFiles: 'image/*',
    addRemoveLinks: true,

    init: function () {

    }

}