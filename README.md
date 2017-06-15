# FormListGenerator

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]

This is where your description should go. Try and limit it to a paragraph or two, and maybe throw in a mention of what
PSRs you support to avoid any confusion with users and contributors.

## Structure

If any of the following are applicable to your project, then the directory structure should follow industry best practises by being named the following.

```
bin/        
config/
src/
tests/
vendor/
```


## Install

Via Composer

``` bash
$ composer require PascalKleindienst/FormListGenerator
```

## Usage

``` php
$skeleton = new PascalKleindienst\FormListGenerator();
echo $skeleton->echoPhrase('Hello, League!');
```

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

[ico-version]: https://img.shields.io/packagist/v/PascalKleindienst/FormListGenerator.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/PascalKleindienst/FormListGenerator/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/PascalKleindienst/FormListGenerator.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/PascalKleindienst/FormListGenerator.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/PascalKleindienst/FormListGenerator.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/PascalKleindienst/FormListGenerator
[link-travis]: https://travis-ci.org/PascalKleindienst/FormListGenerator
[link-scrutinizer]: https://scrutinizer-ci.com/g/PascalKleindienst/FormListGenerator/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/PascalKleindienst/FormListGenerator
[link-downloads]: https://packagist.org/packages/PascalKleindienst/FormListGenerator
[link-author]: https://github.com/PascalKleindienst
[link-contributors]: ../../contributors
