php-upload
==========

Class PHP upload file.

## Installation / Usage
-----------------

1. Download the [`composer.phar`](https://getcomposer.org/composer.phar) executable or use the installer.

    ``` sh
    $ curl -sS https://getcomposer.org/installer | php
    ```
    
2. Create a composer.json defining your dependencies. Note that this example is
a short version for applications that are not meant to be published as packages
themselves. To create libraries/packages please read the
[documentation](http://getcomposer.org/doc/02-libraries.md).

    ``` json
    {
        "repositories": [
     	    {"type": "git", "url": "https://github.com/offboard/php-upload"}
        ], 
        "require": {  
            "offboard/php-upload": "dev-master"
        }
    }
    ```
3. Run Composer: `php composer.phar install`
4. Browse for more packages on [Packagist](https://packagist.org).

## Updating Composer
-----------------

Running `php composer.phar self-update` or `composer update` is equivalent you will update a phar
install with the latest version.

## Installation from Source
------------------------

1. Run `git clone https://github.com/offboard/php-upload.git /var/www/your-project/libs/`
3. Include the class in your project file: `include('./Lib/Upload.php');`


### Simple Example
-----------------
```php
include("../autoload.php");

$upload = new Upload('img');
$upload
        ->file_name('uploaded')
        ->upload_to('upload/')
        ->run();

if (!$upload->was_uploaded) {
    die("Error : {$upload->error}");
} else {
    echo 'image sent successfully !';
}
```

### Example random name 
-----------------
```php
include("../autoload.php");

$upload = new Upload('img');
$upload
        ->file_name(true)
        ->upload_to('upload/')
        ->run();

if (!$upload->was_uploaded) {
    die("Error : {$upload->error}");
} else {
    echo 'image sent successfully !';
}
```

### Example maximum allowed size
-----------------
```php
include("../autoload.php");

$upload = new Upload('img');
$upload
        ->file_name('uploaded')
        ->upload_to('upload/')
        ->file_max_size(1000000 * 4) // 1000000 bytes = 1 MB
        ->run();

if (!$upload->was_uploaded) {
    die("Error : {$upload->error}");
} else {
    echo 'image sent successfully !';
}
```

### Example disable mime checker
-----------------
```php
include("../autoload.php");

$upload = new Upload('img');
$upload
        ->file_name('uploaded')
        ->upload_to('upload/')
        ->mime_check(false)
        ->run();

if (!$upload->was_uploaded) {
    die("Error : {$upload->error}");
} else {
    echo 'image sent successfully !';
}
```

### Example resize image
-----------------
```php
include("../autoload.php");

$upload = new Upload('img');
$upload
        ->file_name('resized')
        ->upload_to('upload/')
        ->resize_to(150, 150, 'exact') // resize exact to 150x150 pixels
        ->run();

if (!$upload->was_uploaded) {
    die("Error : {$upload->error}");
} else {
    echo 'image sent successfully !';
}
```

### Example custom mime checker
-----------------
```php
include("../autoload.php");

$upload = new Upload('img');
// only imagens
$upload->MIME_allowed = array(
    "image/jpeg",
    "image/pjpeg",
    "image/bmp",
    "image/gif",
    "image/png",
);
$upload
        ->file_name('resized')
        ->upload_to('upload/')
        ->resize_to(480, 380, "maxwidth") // resize exact to 150x150 pixels
        ->run();

if (!$upload->was_uploaded) {
    die("Error : {$upload->error}");
} else {
    echo 'image sent successfully !';
}
```

### Example multiple upload
-----------------
```php
include("../autoload.php");

$file = $_FILES['img'];
if (empty($file['tmp_name'][0])) {
    die("No images");
}
foreach ($file["tmp_name"] as $k => $v) {
    $upload = new Upload(array(
      'name' => $file['name'][$k],
      'type' => $file['type'][$k],
       'tmp_name' => $file['tmp_name'][$k],
       'error' => $file['error'][$k],
       'size' => $file['size'][$k]
    ), false);
    $upload
            ->file_name(true)
            ->upload_to('document/')
            ->run();
    if (!$upload->was_uploaded) {
       die("Error image {$i} : {$upload->error}");
    } 
    echo "image {$i} sent successfully !";
}
```

### Example Watermark upload
-----------------
```php
include("../autoload.php");

$upload = new Upload('img');
$upload
        ->file_name(true)
        ->upload_to('upload/')
        ->watermark('watermark.png', 'center') // insert watermark, set align center, botton_right or botton_right_small
        ->run();

if (!$upload->was_uploaded) {
    die("Error : {$upload->error}");
} else {
    echo 'image sent successfully !';
}
```

## External Examples
-----------------

You can use the classes `new ResizeUpload()` and `new Watermark()`
in your projects without having to load the class Upload.

### Upload image from base64 string
-----------------
```php
function base64ToJpeg($base64_string) {
  $data = explode(';', $base64_string);
  $dataa = explode(',', $base64_string);
  $part = explode("/", $data[0]);
  $file = md5(uniqid(rand(), true)) . ".{$part[1]}"; // rand name + extension
  if (!is_dir("upload/"))
     mkdir("upload/");

   $ifp = fopen("upload/{$file}", 'wb');
   fwrite($ifp, base64_decode($dataa[1]));
   fclose($ifp);
   return $file;
}

if (!file_exists(self::base64ToJpeg($base64))
   die("Upload error");

```
### Upload image from base64 string + External ResizeTo()
-----------------
```php
if (!file_exists($filename = base64ToJpeg($base64))
   die("Upload error");

$resize = new ResizeImage($filename);
$resize->resizeTo(660, 370, 'exact');
$resize->saveImage($filename);

```

### Upload image from base64 string + External Watermark()
-----------------
```php
if (!file_exists($filename = base64ToJpeg($base64))
   die("Upload error");

$watermark = new Watermark($filename);
$watermark->setType(Watermark::CENTER); // align center
$watermark->setWatermarkImage("images/watermark.png");
$watermark->saveAs($filename);
```


### Example Upload image from base64 string + External ResizeTo() & Watermark()
-----------------
```php
if (!file_exists($filename = base64ToJpeg($base64))
   die("Upload error");
        
$resize = new ResizeImage($filename);
$resize->resizeTo(660, 370, 'exact');
$resize->saveImage($filename);
        
$watermark = new Watermark($filename);
$watermark->setType(Watermark::CENTER); // align center
$watermark->setWatermarkImage("images/watermark.png");
$watermark->saveAs($filename);
```

## Donations
-----------------

### (BTC) BITCOIN
``1JZVdm8HJUNV5uDrLeQbFph4Hgv4fTDUYb``

### (ETH) ETHEREUM
``0x78e7c45d8c4ef58034e5dd1f2cfed1cc665f7e11``

### (DSH) DASH
``XhFyk1RA8rfhhFtbNcaZgxBMcAoSCDY1gJ``

### (LTC) LITECOIN
``LhGUQb2cCo6kA1nNjhPrsqE3Q3W54qdpkr``

### (DGE) DOGER
``DJ1C6eE7w1SzkFo2KMz6P6my89VqFombwn``
