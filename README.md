# FormListGenerator

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Code Style][ico-code-style]][link-code-style]
[![Total Downloads][ico-downloads]][link-downloads]

FormListGenerator is a small library to easily display data as a table-list or a form. Its main application area is in admin/backend applications.

## Install

Via Composer

``` bash
$ composer require pascalkleindienst/form-list-generator
```

## Usage

``` php
use PascalKleindienst\FormListGenerator\Generators\ListGenerator;
use PascalKleindienst\FormListGenerator\Generators\FormGenerator;
use PascalKleindienst\FormListGenerator\Support\Config;

# set the root path of the application and optionally a baseUrl
Config::set([
    'root'    => dirname(__FILE__),
    'baseUrl' => 'http://example.com'
]);

// Init Generators with yaml config
$list = new ListGenerator('list.yaml'); 
$form = new FormGenerator('form.yaml');

// Alternatively, we can use the load method (useful when you put the generator class in a container)
$list = new ListGenerator(); 
$form = new FormGenerator();
$list = $list->load('list.yaml');
$form = $form->load('form.yaml');

// Render List
# some example date, usually fetched from your DB
$listData = [
    [
        'id'         => 1,
        'full_name'  => 'John Doe',
        'age'        => 42,
        'created_at' => time(),
        'content'    => 'lorem ipsum'
    ],
    [
        'id'         => 2,
        'full_name'  => 'John Doe',
        'age'        => 42,
        'created_at' => time(),
        'content'    => 'lorem ipsum'
    ]
];
$list->render($listData);

// Render the form
$formData = [
    'id'         => 1,
    'full_name'  => 'John Doe',
    'age'        => 42,
    'created_at' => time(),
    'content'    => 'lorem ipsum'
];
$form->render($formData);
```

### Configuration
See [docs/form.md](docs/form.md) and [docs/list.md](docs/list.md)

### Localization
You're also able to translate your message to another language. The only thing one must do is to set the attribute translator as a callable that will handle the translation:
```php
$form->setTranslator('gettext');
$list->setTranslator('gettext');
```
The example above uses `gettext()` but you can use any other callable value, like `[$translator, 'trans']` or `your_custom_function()`.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email mail@pascalkleindienst.de instead of using the issue tracker.

## Credits

- [Pascal Kleindienst][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/pascalkleindienst/form-list-generator.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/PascalKleindienst/FormListGenerator/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/PascalKleindienst/FormListGenerator.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/PascalKleindienst/FormListGenerator.svg?style=flat-square
[ico-code-style]: https://styleci.io/repos/94441385/shield?branch=master
[ico-downloads]: https://img.shields.io/packagist/dt/pascalkleindienst/form-list-generator.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/pascalkleindienst/form-list-generator
[link-travis]: https://travis-ci.org/PascalKleindienst/FormListGenerator
[link-scrutinizer]: https://scrutinizer-ci.com/g/PascalKleindienst/FormListGenerator/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/PascalKleindienst/FormListGenerator
[link-downloads]: https://packagist.org/packages/pascalkleindienst/form-list-generator
[link-author]: https://github.com/PascalKleindienst
[link-contributors]: ../../contributors
[link-code-style]: https://styleci.io/repos/94441385