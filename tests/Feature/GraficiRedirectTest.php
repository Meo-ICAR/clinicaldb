<?php

namespace Tests\Feature;

use App\Models\User;
use App\Services\SsoTokenBroker;
use Tests\TestCase;

class GraficiRedirectTest extends TestCase
{
    public function test_authenticated_user_is_redirected_with_a_valid_sso_token(): void
    {
        config()->set('services.grafici.url', 'https://grafici.test');

        $response = $this->actingAs(User::factory()->make(['email' => 'agente@example.com']))
            ->get(route('grafici'));

        $response->assertRedirectContains('https://grafici.test/bpm-landing/dashboard?');

        parse_str(parse_url($response->headers->get('Location'), PHP_URL_QUERY), $query);

        $this->assertSame('clinicaldb', $query['source']);
        $this->assertSame('agente@example.com', $query['user_email']);
        $this->assertTrue(app(SsoTokenBroker::class)->verifyAndConsume($query['token'], 'agente@example.com'));
    }

    public function test_guest_is_sent_to_the_login(): void
    {
        $this->get(route('grafici'))->assertRedirect(route('filament.admin.auth.login'));
    }
}
