<?php

include("./Lib/Upload.php");

$upload = new Upload('img');
$upload
        ->file_name('uploaded')
        ->upload_to('upload/')
        ->run();
if (!$upload->was_uploaded) {
    die('error : ' . $upload->error);
} else {
    echo 'image sent successfully !';
}
