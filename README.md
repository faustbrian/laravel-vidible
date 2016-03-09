# Laravel Vidible

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]

## Install

Via Composer

``` bash
$ composer require draperstudio/laravel-vidible
```

And then include the service provider within `app/config/app.php`.

``` php
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

## Usage

``` php
<?php

/*
 * This file is part of Laravel Vidible.
 *
 * (c) DraperStudio <hello@draperstudio.tech>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) and [CONDUCT](CONDUCT.md) for details.

## Security

If you discover any security related issues, please email hello@draperstudio.tech instead of using the issue tracker.

## Credits

- [DraperStudio][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.


<!-- ## To-Do
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
- Write more descriptive comments -->


[ico-version]: https://img.shields.io/packagist/v/DraperStudio/laravel-vidible.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/DraperStudio/Laravel-Vidible/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/DraperStudio/laravel-vidible.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/DraperStudio/laravel-vidible.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/DraperStudio/laravel-vidible.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/DraperStudio/laravel-vidible
[link-travis]: https://travis-ci.org/DraperStudio/Laravel-Vidible
[link-scrutinizer]: https://scrutinizer-ci.com/g/DraperStudio/laravel-vidible/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/DraperStudio/laravel-vidible
[link-downloads]: https://packagist.org/packages/DraperStudio/laravel-vidible
[link-author]: https://github.com/DraperStudio
[link-contributors]: ../../contributors
