# A simple single field repeater field for Filament.

[![Latest Version on Packagist](https://img.shields.io/packagist/v/ryangjchandler/filament-simple-repeater.svg?style=flat-square)](https://packagist.org/packages/ryangjchandler/filament-simple-repeater)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/ryangjchandler/filament-simple-repeater/run-tests?label=tests)](https://github.com/ryangjchandler/filament-simple-repeater/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/ryangjchandler/filament-simple-repeater/Check%20&%20fix%20styling?label=code%20style)](https://github.com/ryangjchandler/filament-simple-repeater/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/ryangjchandler/filament-simple-repeater.svg?style=flat-square)](https://packagist.org/packages/ryangjchandler/filament-simple-repeater)

This package provides a simple repeater field for Filament that lets you repeat a single field with a minimal UI.

## Installation

You can install the package via Composer:

```bash
composer require ryangjchandler/filament-simple-repeater
```

## Usage

This field behaves like other Filament fields and can be used with all three packages (tables, forms and admin).

```php
use RyanChandler\FilamentSimpleRepeater\SimpleRepeater;

protected function getFormSchema(): array
{
    return [
        SimpleRepeater::make('emails')
            ->field(
                TextInput::make('email')
                    ->required()
                    ->email()
            )
    ];
}
```

The `SimpleRepeater::field()` method accepts any object that extends the `Filament\Forms\Components\Field` class. It doesn't support repeating `Grid`, `Group` or `Section` objects. That behaviour is better suited to Filament's own `Repeater` field.

### Default items

By default, the `SimpleRepeater` will output 1 empty field when it has no value. If you would like to change this behaviour, use the `SimpleRepeater::defaultItems()` method.

```php
SimpleRepeater::make('emails')
    ->defaultItems(2)
    ->field(
        TextInput::make('email')
            ->required()
            ->email()
    )
```

The field will now show 2 inputs by default.

### Disabling item deletion

By default, all items can be deleted in a similar fashion to Filament's own `Repeater`.

To disable this behaviour, call the `SimpleRepeater::disableItemDeletion()` method.

```php
SimpleRepeater::make('emails')
    ->disableItemDeletion()
```

### Disabling item movement / sorting

By default, all items can be moved / sorted using with drag and drop if there is more than 1 item.

To disable this behaviour, call the `SimpleRepeater::disableItemMovement()` method.

```php
SimpleRepeater::make('emails')
    ->disableItemMovement()
```

### Item limits

The `SimpleRepeater` field supports both `minItems` and `maxItems` method calls like the regular `Repeater` field. This will register validation rules to ensure that the submitted data meets both the minimum and maximum limits specified.

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Ryan Chandler](https://github.com/ryangjchandler)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
