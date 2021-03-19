<?php


namespace Tests;


use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Tests\PageObject\PaginaInicial;
use Tests\PageObject\PaginaLogin;

class PaginaListagemTest extends \PHPUnit\Framework\TestCase
{
    public function testAlterarNomeDoSeriado()
    {
        // Arrange
        $host           = 'http://localhost:4444/wd/hub';
        $driver         = RemoteWebDriver::create($host, DesiredCapabilities::chrome());
        $paginaLogin    = new PaginaLogin($driver);
        $paginaLogin->realizaLoginCom('email@example.com', '123');
        $paginaInicial  = new PaginaInicial($driver);
        $paginaInicial->visita();

        // Act

        $nomeSerieAlterada  = 'Série alterada';
        $idSerieParaAlterar = 2;
        $paginaInicial->clicaParaEditarSeriadoDeId($idSerieParaAlterar)
                      ->defineNomeDoSeriadoDeId($idSerieParaAlterar, $nomeSerieAlterada)
                      ->finalizaEdicaoDoSeriadoDeId($idSerieParaAlterar);

        // Assert
        self::assertSame($nomeSerieAlterada, $paginaInicial->nomeSeriadoDeId($idSerieParaAlterar));

        $driver->close();

    }
}