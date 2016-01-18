# Laravel Vidible

## Installation

First, pull in the package through Composer.

```js
composer require draperstudio/laravel-vidible:1.0.*@dev
```

And then include the service provider within `app/config/app.php`.

```php
'providers' => [
    'DraperStudio\Vidible\VidibleServiceProvider'
];
```

To get started, you'll need to publish the vendor assets and modify it:

```bash
php artisan vendor:publish
```

The package configuration will now be located at `app/config/vidible.php` and the migration at `database/migrations/2015_01_30_000000_create_vidible_table.php`.


To finish the installation you need to migrate the vidible table by executing:

```bash
php artisan migrate
```

#### Including the Trait
```php
<?php

namespace App;

use DraperStudio\Vidible\Contracts\Vidible as VidibleContract;
use DraperStudio\Vidible\Traits\VidibleTrait;

class User extends Model implements VidibleContract {

    use VidibleTrait;

}
```

#### Example
```php
<?php



namespace App\Http\Controllers;

use App\User;
use DraperStudio\Vidible\VidibleService as Vidible;
use Illuminate\Http\Request;

class VidibleController extends Controller {

    public function index(Request $request, Vidible $vidible)
    {
        // Load the model the video will be attached to
        $user = User::find(1);

        // The video that should be uploaded
        $file = $request->files->all()['video'];

        // Upload the video and create a database record
        $video = $vidible->withFile($file)
                         ->withModel($user)
                         ->withAttributes(['slot' => 'trailer'])
                         ->withFilters(['watermark'])
                         ->commit(true);

        // Get the shareable url of the created video
        $video = $vidible->withFilters(['watermark'])
                         ->getShareableLink($video);

        // Display the shareable url
        echo($video);
    }

}
```

## To-Do
- Implement **Batch processing** with an easy to use syntax.
- Implement **Move to Slot** with an easy to use syntax.
- Implement **getShareableLink** for the following adapters
    - Azure
    - Copy
    - Ftp
    - GridFs
    - Rackspace
    - Sftp
    - WebDav
    - ZipArchive
- Refactoring and Package structuring
- Write more about how to use the package
- Write more descriptive comments
