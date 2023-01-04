<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <title>PHP chunk File upload using javascript </title>
</head>

<body>
    <div class="container">
        <h1>PHP Chunk File Upload using JavaScript & PHP</h1>
        <div class="wrapper">
            <div class="col-md-12">
                <div id="statusResponse"></div>
                <!-- File Uplaod -->
                <div class='file-input form-group'>
                    <input type='file' id="fileInput">
                    <span class='button'>Choose</span>
                    <span class='label' data-js-label>Select File</label>
                </div>
                <div id="fileList"></div>
                <!-- Upload Button -->
                <div class="form-group">
                    <a href="javascript:;" id="uploadBtn" class="btn btn-success">Upload</a>
                </div>
                <!-- File Progress Bar -->
                <div class="progress"></div>
            </div>
        </div>
    </div>
    <script>
        // Define Plupload uploader with configuration options
        var uploader = new plupload.Uploader({
            runtimes: 'html5,flash,silverlight,html4',
            browse_button: 'fileInput', // you can pass an id...
            url: 'upload.php',
            flash_swf_url: 'plupload/js/Moxie.swf',
            silverlight_xap_url: 'plupload/js/Moxie.xap',
            multi_selection: false,

            filters: {
                max_file_size: '500mb',
                mime_types: [{
                        title: "Image files",
                        extensions: "jpg,jpeg,gif,png"
                    },
                    {
                        title: "Video files",
                        extensions: "mp4,avi,mpeg,mpg,mov,wmv"
                    },
                    {
                        title: "Zip files",
                        extensions: "zip"
                    },
                    {
                        title: "Document files",
                        extensions: "pdf,docx,xlsx"
                    }
                ]
            },

            init: {
                PostInit: function() {
                    document.getElementById('fileList').innerHTML = '';

                    document.getElementById('uploadBtn').onclick = function() {
                        if (uploader.files.length < 1) {
                            document.getElementById('statusResponse').innerHTML = '<p style="color:#EA4335;">Please select a file to upload.</p>';
                            return false;
                        } else {
                            uploader.start();
                            return false;
                        }
                    };
                },

                FilesAdded: function(up, files) {
                    plupload.each(files, function(file) {
                        document.getElementById('fileList').innerHTML += '<div id="' + file.id + '">' + file.name + ' (' + plupload.formatSize(file.size) + ') <b></b></div>';
                    });
                },

                UploadProgress: function(up, file) {
                    document.getElementById(file.id).getElementsByTagName('b')[0].innerHTML = '<span>' + file.percent + "%</span>";
                    document.querySelector(".progress").innerHTML = '<div class="progress-bar" style="width: ' + file.percent + '%;">' + file.percent + '%</div>';
                },

                FileUploaded: function(up, file, result) {
                    var responseData = result.response.replace('"{', '{').replace('}"', '}');
                    var objResponse = JSON.parse(responseData);
                    document.getElementById('statusResponse').innerHTML = '<p style="color:#198754;">' + objResponse.result.message + '</p>';
                },

                Error: function(up, err) {
                    document.getElementById('statusResponse').innerHTML = '<p style="color:#EA4335;">Error #' + err.code + ': ' + err.message + '</p>';
                }
            }
        });

        // Initialize Plupload uploader
        uploader.init();
    </script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
</body>

</html>