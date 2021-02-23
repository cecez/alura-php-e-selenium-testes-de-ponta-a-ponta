<?php

use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Remote\RemoteWebElement;
use Facebook\WebDriver\WebDriverBy;
use PHPUnit\Framework\TestCase;

class RegistroTest extends TestCase {

    public function testQuandoRegistrarNovoUsuarioDeveRedirecionarParaListaDeSeries()
    {
        // Arrange
        $host   = 'http://localhost:4444/wd/hub';
        $driver = RemoteWebDriver::create($host, DesiredCapabilities::chrome());
            // acessa página de registro de usuário
            $driver->get('http://localhost:8000/novo-usuario');

        // Act
            // busca cada elemento do form e preenche com dados
            $driver->findElement(WebDriverBy::id('email'))->sendKeys('email2@exemplo.com');
            $driver->findElement(WebDriverBy::id('name'))->sendKeys('Nome Fictício');
            $driver->findElement(WebDriverBy::id('password'))->sendKeys('qwe123');
            // clica no botão de enviar
            $driver->findElement(WebDriverBy::tagName('button'))->click();

        // Assert
            // garante que está na página esperada
            self::assertSame('http://localhost:8000/series', $driver->getCurrentURL());
            // e que existe um link Sair
            self::assertInstanceOf(
                RemoteWebElement::class,
                $driver->findElement(WebDriverBy::linkText('Sair'))
            );
    }

}