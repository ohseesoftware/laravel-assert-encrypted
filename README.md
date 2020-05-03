# Laravel Assert Encrypted

[![Current Release](https://img.shields.io/github/release/ohseesoftware/laravel-assert-encrypted.svg?style=flat-square)](https://github.com/ohseesoftware/laravel-assert-encrypted/releases)
![Build Status Badge](https://github.com/ohseesoftware/laravel-assert-encrypted/workflows/Build/badge.svg)
[![Coverage Status](https://coveralls.io/repos/github/ohseesoftware/laravel-assert-encrypted/badge.svg?branch=master)](https://coveralls.io/github/ohseesoftware/laravel-assert-encrypted?branch=master)
[![Maintainability Score](https://img.shields.io/codeclimate/maintainability/ohseesoftware/laravel-assert-encrypted.svg?style=flat-square)](https://codeclimate.com/github/ohseesoftware/laravel-assert-encrypted)
[![Downloads](https://img.shields.io/packagist/dt/ohseesoftware/laravel-assert-encrypted.svg?style=flat-square)](https://packagist.org/packages/ohseesoftware/laravel-assert-encrypted)
[![MIT License](https://img.shields.io/github/license/ohseesoftware/laravel-assert-encrypted.svg?style=flat-square)](https://github.com/ohseesoftware/laravel-assert-encrypted/blob/master/LICENSE)

Add an assertion to test for encrypted values in your database.

Say you have an encrypted value in your database:

```php
User::create([
    'name' => 'John Doe',
    'secret' => encrypt('api-key')
]);
```

It's a bit hard to test the value of `secret` in the database because there's randomness in `encrypt()`. This means `encrypt('value') !== encrypt('value')`.

To get around this, you can use the trait exposed in this package in your tests:

```php
import OhSeeSoftware\LaravelAssertEncrypted\Traits\EncryptedAssertion;

class SomeTest extends TestCase
{
    use AssertEncrypted;

    /** @test */
    public function it_stores_users_secrets()
    {
        // Given
        $user = factory(User::class)->create([
            'secret' => encrypt('api-key')
        ]);

        // Then
        $this->assertEncrypted('users', ['id' => $user->id], [
            'secret' => 'api-key'
        ]);
    }
}
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email security@ohseesoftware.com instead of using the issue tracker.

## Credits

-   [Owen Conti](https://github.com/ohseesoftware)
-   [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Laravel Package Boilerplate

This package was generated using the [Laravel Package Boilerplate](https://laravelpackageboilerplate.com).
