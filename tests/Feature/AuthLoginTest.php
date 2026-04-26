<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class AuthLoginTest extends TestCase
{
    public function test_login_page_is_accessible(): void
    {
        $response = $this->get('/');

        $response->assertOk();
        $response->assertSee('Masuk ke MyAds');
        $response->assertSee(route('register'));
        $response->assertSee(route('password.request'));
    }

    public function test_register_page_is_accessible(): void
    {
        $response = $this->get('/register');

        $response->assertOk();
        $response->assertSee('Daftar akun MyAds');
    }

    public function test_forgot_password_page_is_accessible(): void
    {
        $response = $this->get('/forgot-password');

        $response->assertOk();
        $response->assertSee('Lupa password');
    }

    public function test_reset_password_page_is_accessible(): void
    {
        $response = $this->get('/reset-password/sample-token?email=operator@myads.test');

        $response->assertOk();
        $response->assertSee('Reset password');
    }

    public function test_guest_is_redirected_from_dashboard(): void
    {
        $response = $this->get('/dashboard');

        $response->assertRedirect('/');
    }

    public function test_authenticated_user_can_open_dashboard(): void
    {
        $user = new User([
            'name' => 'Ads Operator',
            'email' => 'operator@myads.test',
            'password' => 'password',
        ]);

        $response = $this->actingAs($user)->get('/dashboard');

        $response->assertOk();
        $response->assertSee('Selamat Datang,');
        $response->assertSee('Ads Operator');
        $response->assertSee('Ringkasan Dashboard');
        $response->assertSee('SMS');
        $response->assertSee('WA Business');
        $response->assertSee('Location Based Area belum diisi.');
    }

    public function test_authenticated_user_can_open_sms_location_based_area_page(): void
    {
        $user = new User([
            'name' => 'Ads Operator',
            'email' => 'operator@myads.test',
            'password' => 'password',
        ]);

        $response = $this->actingAs($user)->get('/campaign/sms/location-based-area');

        $response->assertOk();
        $response->assertSee('Buat Judul Iklan');
        $response->assertSee('Konten Pesan Iklan');
        $response->assertSee('Atur Pengiriman');
    }

    public function test_authenticated_user_can_open_sms_targeted_page(): void
    {
        $user = new User([
            'name' => 'Ads Operator',
            'email' => 'operator@myads.test',
            'password' => 'password',
        ]);

        $response = $this->actingAs($user)->get('/campaign/sms/targeted');

        $response->assertOk();
        $response->assertSee('Buat Judul Iklan');
        $response->assertSee('Konten Pesan Iklan');
        $response->assertSee('Review & Pembayaran');
    }
}
