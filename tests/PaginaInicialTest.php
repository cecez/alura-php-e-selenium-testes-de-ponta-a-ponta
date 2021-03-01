<?php


namespace Tests;


use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverBy;

class PaginaInicialTest extends \PHPUnit\Framework\TestCase
{
    public function testPaginaInicialNaoLogadoDeveSerListagemDeSeries()
    {
        // Arrange
        $host   = 'http://localhost:4444/wd/hub';
        $driver = RemoteWebDriver::create($host, DesiredCapabilities::chrome());

        // Act
        $driver->navigate()->to('http://localhost:8000');

        // Assert
        $h1Locator  = WebDriverBy::tagName('h1');
        $textoH1    = $driver->findElement($h1Locator)->getText();
        self::assertStringContainsString('Séries', $textoH1);

        $driver->close();

    }
}