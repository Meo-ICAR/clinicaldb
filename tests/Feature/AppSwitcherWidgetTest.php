<?php

namespace Tests\Feature;

use App\Filament\Widgets\AppSwitcherWidget;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Livewire\Livewire;
use Tests\TestCase;

class AppSwitcherWidgetTest extends TestCase
{
    public function test_lists_apps_that_report_a_matching_account(): void
    {
        $user = User::factory()->make(['email' => 'agente@example.com']);
        $this->actingAs($user);

        config()->set('services.apps', [
            'daishboard' => ['url' => 'https://daishboard.test', 'label' => 'Dashboard'],
        ]);

        Http::fake([
            'https://daishboard.test/api/users/lookup*' => Http::response(['exists' => true]),
        ]);

        Livewire::test(AppSwitcherWidget::class)
            ->assertSee('Dashboard');
    }

    public function test_shows_an_empty_state_when_no_other_app_has_a_matching_account(): void
    {
        $user = User::factory()->make(['email' => 'agente@example.com']);
        $this->actingAs($user);

        config()->set('services.apps', [
            'daishboard' => ['url' => 'https://daishboard.test', 'label' => 'Dashboard'],
        ]);

        Http::fake([
            'https://daishboard.test/api/users/lookup*' => Http::response(['exists' => false]),
        ]);

        Livewire::test(AppSwitcherWidget::class)
            ->assertSee('Nessun altro account trovato con questa email.');
    }
}
