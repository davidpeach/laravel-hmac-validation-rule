# Laravel Hmac Validation Rule

A [Laravel Rule Object](https://laravel.com/docs/8.x/validation#using-rule-objects) for checking an Hmac hash based 
on any of your request key / value pairs.

## Usage

Define the `.env` variable `HMAC_VALIDATION_SECRET` to be your shared secret. This will be the same secret that the 
client uses to hash the required values.

The client sending the data to your endpoint should json encode the data in the same order that you are passing them 
into your usage of the `Hmac` rule object. Then they should calculate a Hmac hash of that json string and pass it 
with the request. (as the key `hmac` in this example, but it could be any key). Only the `sha256` algorithm is 
currently supported, but this will be configurable soon.

```php
use DavidPeach\LaravelHmacValidatorRule\Rules\Hmac;

[...]

public function store(\Illuminate\Http\Request $request)
{
    $request->validate([
        'email' => ['required', 'email'],
        'data' => ['required'],
        'hmac' => new Hmac($request->only(['email', 'data'])),
    ]);
}
```
