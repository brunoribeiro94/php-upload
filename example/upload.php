<?php

$upload = new Upload('img');
$upload
        ->file_name('uploaded')
        ->upload_to('/home/user/files/')
        ->run();

if (!$upload->was_uploaded) {
    die('error : ' . $upload->error);
}
