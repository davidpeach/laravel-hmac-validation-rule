# Laravel Hmac Validation Rule

A [Laravel Rule Object](https://laravel.com/docs/8.x/validation#using-rule-objects) for checking an Hmac hash based 
on any of your request key / value pairs.

## Why

Sometimes you may want some extra assurance that the data that arrives at its intended destination is the exact 
data that was sent.

We can do this by "signing" the data with a secret key (a random string of characters) that only the client and the 
destination know.

The client signs the data and sends it to the destination along with the data hash they created. Then the 
destination, on receiving the request, will hash the data themselves using the same secert key and check that their 
data hash is exactly the same. If it differs, you can disregard and return an error status.

## Example Usage

For this example lets say you are building an endpoint that will accept an email and a name that you need to 
make sure has not been tampered with.

Here are the steps:
1. As the API designer, decide which parts of the data you want to build the hash from, and in which order.
   1. For this example, let's say we want both the email and name fields to be used for the hash.
   2. The fields should be in the same order when hashed, as the ordering will affect the end hash result.
   3. I may add a configuration option to alphabetise the fields based on their keys in the near future.
2. In your request validation, use the Hmac rule object like in the example here:

```php
use DavidPeach\LaravelHmacValidatorRule\Rules\Hmac;

[...]

public function store(\Illuminate\Http\Request $request)
{
    $request->validate([
        'email' => ['required', 'email'],
        'name' => ['required'],
        'hmac' => new Hmac($request->only(['email', 'name'])),
    ]);
}
```

3. Define the `.env` variable `HMAC_VALIDATION_SECRET` to be your shared secret. This will be the same secret that the
client uses to hash the required fields.

4. The client sends the request along with the hmac hash they have calculated using the shared secret:

```php
#########################
# Example hashing in PHP
#########################

# The data to hash and send.
$dataToSend = [
    'email' => 'test@example.com',
    'name'  => 'David Peach',
];

# Encode data to a JSON string.
$jsonEncodedDataString = json_encode($dataToSend);

# Calculate the HMAC hash (sha256 only at the moment)
# all the other hash_hmac algorithms will be available soon.
$hmacHash = hash_hmac('sha256', $jsonEncodedDataString, 'YOUR_SHARED_SECRET');

# Add the calculated HMAC hash on to the data to send.
$dataToSend['hmac'] = $hmacHash;

# Send the request to the endpoint.

```
The client sending the data to your endpoint should json encode the data in the same order that you are passing them
into your usage of the `Hmac` rule object. Then they should calculate a Hmac hash of that json string and pass it
with the request. (as the key `hmac` in this example, but it could be any key). Only the `sha256` algorithm is
currently supported, but this will be configurable soon.
