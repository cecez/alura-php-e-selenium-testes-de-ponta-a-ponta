<?php

namespace Tests\Browser;

use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class LoginTest extends DuskTestCase
{
    //use DatabaseMigrations;

    /**
     * A Dusk test example.
     *
     * @return void
     * @throws \Throwable
     */
    public function testAoSeLogarLinkSairDeveSerExibidoAoInvesDeEntrar()
    {
        $user = factory(User::class)->create();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->visit('http://localhost:8000/entrar')
                    ->type('email', 'email@example.com')
                    ->type('password', '123')
                    ->press('Entrar')
                    ->assertPathIs('/series')
                    ->assertSeeLink('Sair')
                    ->assertDontSeeLink('Entrar');
        });
    }
}
