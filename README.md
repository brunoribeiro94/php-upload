php-upload
==========

Class PHP upload file.

## Simple Example
```php
include("./Lib/Upload.php");

$upload = new Upload('img');
$upload
        ->file_name(true)
        ->upload_to('upload/')
        ->run();

if (!$upload->was_uploaded) {
    die('Error : ' . $upload->error);
} else {
    echo 'image sent successfully !';
}
```
