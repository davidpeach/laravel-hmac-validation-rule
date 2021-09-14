<?php

namespace DavidPeach\LaravelHmacValidatorRule\Tests\Unit\Rules;

use DavidPeach\LaravelHmacValidatorRule\Rules\Hmac;
use DavidPeach\LaravelHmacValidatorRule\Tests\TestCase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class HmacTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        Config::set('hmac.secret', 'a-test-secret');
    }

    /**
     * @test
     * @dataProvider dataHmacPairs()
     */
    public function it_correctly_validates_a_sha256_hmac_from_the_given_request_key_value_pairs(
        $dataToHash,
        $correctHmacHash
    ){
        $hmacRule = new Hmac($dataToHash);

        $this->assertTrue($hmacRule->passes('hmac', $correctHmacHash));
    }

    public function dataHmacPairs(): array
    {
        return [
            [
                [
                    'email' => 'test@example.com',
                ],
                'b9306a5aef33f03c5f91e1cd3f90f67c3545338d6c7764fb4d3586cf3928f9dd',
            ],
            [
                [
                    'email' => 'test@example.com',
                    'first_name' => 'David',
                    'last_name' => 'Peach',
                ],
                '6718545926ce65657be629dc1ae3aa2c93fd0460f3585156185bcad9c4998bde',
            ]
        ];
    }

    /**
     * @test
     * @dataProvider  dataHmacFailedValidationMessagePairs()
     */
    public function failed_hmac_validation_will_return_correct_error_message(
        $requestData,
        $errorMessage
    ){
        $request = new Request();
        $request->replace($requestData);

        $rules = [
            'hmac' => [new Hmac($request->except('hmac'))]
        ];

        $validator = $this->app['validator']->make($request->all(), $rules);

        $this->assertFalse($validator->passes());
        $this->assertArrayHasKey(
            'hmac', $validator->errors()->toArray()
        );
        $this->assertEquals(
            $errorMessage,
            $validator->errors()->toArray()['hmac'][0]
        );
    }

    public function dataHmacFailedValidationMessagePairs(): array
    {
        return [
            [
                [
                    'email' => 'test@example.com',
                    'hmac'  => 'an-incorrect-hmac-hash',
                ],
                'Please provide a valid hmac using key value pairs for the fields: email.',
            ],
            [
                [
                    'email' => 'test@example.com',
                    'first_name' => 'David',
                    'last_name' => 'Peach',
                    'hmac'  => 'an-incorrect-hmac-hash',
                ],
                'Please provide a valid hmac using key value pairs for the fields: email, first_name, last_name.',
            ]
        ];
    }
}
