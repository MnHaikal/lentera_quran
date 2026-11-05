<?php

namespace Tests\Feature\Auth;

use App\Models\EmailOtp;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use DatabaseTransactions;

    public function test_registration_screen_can_be_rendered(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    public function test_new_users_can_register_and_verify_otp(): void
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertRedirect(route('register.otp.notice'));

        $otpRecord = EmailOtp::where('email', 'test@example.com')->first();
        $this->assertNotNull($otpRecord);

        // Verify OTP
        $verifyResponse = $this->post(route('register.otp.verify'), [
            'otp' => $otpRecord->otp,
        ]);

        $this->assertAuthenticated();
        $verifyResponse->assertRedirect(route('beranda', absolute: false));
        $this->assertDatabaseHas('users', [
            'email' => 'test@example.com',
            'name' => 'Test User',
        ]);
    }

    public function test_otp_verification_fails_with_invalid_otp(): void
    {
        $this->post('/register', [
            'name' => 'Test User 2',
            'email' => 'test2@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response = $this->post(route('register.otp.verify'), [
            'otp' => '000000',
        ]);

        $response->assertSessionHasErrors('otp');
        $this->assertGuest();
    }
}

