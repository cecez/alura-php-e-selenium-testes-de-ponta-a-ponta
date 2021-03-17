<?php

use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Remote\RemoteWebElement;
use Facebook\WebDriver\WebDriverBy;
use PHPUnit\Framework\TestCase;
use Tests\PageObject\PaginaCadastroDeUsuario;

class RegistroTest extends TestCase {

    public function testQuandoRegistrarNovoUsuarioDeveRedirecionarParaListaDeSeries()
    {
        // Arrange
        $driver = RemoteWebDriver::create('http://localhost:4444/wd/hub', DesiredCapabilities::chrome());
        $paginaDeUsuario = new PaginaCadastroDeUsuario($driver);

        // Act
        $paginaDeUsuario->preencheEmail(md5(time()) . '@exemplo.com');
        $paginaDeUsuario->preencheNome('Nome Fictício');
        $paginaDeUsuario->preencheSenha('qwe123');
        $paginaDeUsuario->submeteFormulario();


        // Assert
            // garante que está na página esperada
            self::assertSame('http://localhost:8000/series', $driver->getCurrentURL());
            // e que existe um link Sair
            self::assertInstanceOf(
                RemoteWebElement::class,
                $paginaDeUsuario->obtemLinkSair()
            );

        $driver->close();
    }

}