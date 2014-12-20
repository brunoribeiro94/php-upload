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
        "require": {  
            "offboard/php-upload": "dev-master"
        }
    }
    ```
3. Run Composer: `php composer.phar install`
4. Browse for more packages on [Packagist](https://packagist.org).

## Updating Composer
-----------------

Running `php composer.phar self-update` or equivalent will update a phar
install with the latest version.

## Installation from Source
------------------------

1. Run `git clone https://github.com/offboard/php-upload.git /var/www/your-project/libs/`
3. Include the class in your project file: `include('./Lib/Upload.php');`


## Simple Example
-----------------
```php
include("./Lib/Upload.php");

$upload = new Upload('img');
$upload
        ->file_name('uploaded')
        ->upload_to('upload/')
        ->run();

if (!$upload->was_uploaded) {
    die('Error : ' . $upload->error);
} else {
    echo 'image sent successfully !';
}
```

## Random Name Example
-----------------
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

## Maximum Allowed Size Example
-----------------
```php
include("./Lib/Upload.php");

$upload = new Upload('img');
$upload
        ->file_name('uploaded')
        ->upload_to('upload/')
        ->file_max_size(4000000) // 4000000 bytes = 4 MB
        ->run();

if (!$upload->was_uploaded) {
    die('Error : ' . $upload->error);
} else {
    echo 'image sent successfully !';
}
```

## Mime Checker Example
-----------------
```php
include("./Lib/Upload.php");

$upload = new Upload('img');
$upload
        ->file_name('uploaded')
        ->upload_to('upload/')
        ->mime_check(true) // see $MIME_allowed
        ->run();

if (!$upload->was_uploaded) {
    die('Error : ' . $upload->error);
} else {
    echo 'image sent successfully !';
}
```
