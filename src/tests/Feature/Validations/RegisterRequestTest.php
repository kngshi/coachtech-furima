<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Http\Requests\RegisterRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Models\User;

class RegisterRequestTest extends TestCase
{
    use RefreshDatabase;

    protected function test_validate(array $data)
    {
        $request = new RegisterRequest();
        $validator = Validator::make($data, $request->rules(), $request->messages());
        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
        return $validator->validated();
    }

    public function test_requires_an_email_and_password()
    {
        $this->expectException(ValidationException::class);
        $this->validate([]);
    }

    public function test_validates_email_format()
    {
        $this->expectException(ValidationException::class);
        $this->validate([
            'email' => 'invalid-email',
            'password' => 'validpassword',
        ]);
    }

    public function test_validates_password_min_length()
    {
        $this->expectException(ValidationException::class);
        $this->validate([
            'email' => 'test@example.com',
            'password' => 'short',
        ]);
    }

    public function test_allows_valid_data()
    {
        $validated = $this->validate([
            'email' => 'test@example.com',
            'password' => 'validpassword',
        ]);

        $this->assertArrayHasKey('email', $validated);
        $this->assertArrayHasKey('password', $validated);
    }

    public function test_checks_email_uniqueness()
    {
        User::factory()->create(['email' => 'test@example.com']);

        $this->expectException(ValidationException::class);
        $this->validate([
            'email' => 'test@example.com',
            'password' => 'validpassword',
        ]);
    }
}