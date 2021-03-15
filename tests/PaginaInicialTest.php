<?php


namespace Tests;


use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverBy;
use Tests\PageObject\PaginaInicial;

class PaginaInicialTest extends \PHPUnit\Framework\TestCase
{
    public function testPaginaInicialNaoLogadoDeveSerListagemDeSeries()
    {
        // Arrange
        $host   = 'http://localhost:4444/wd/hub';
        $driver = RemoteWebDriver::create($host, DesiredCapabilities::chrome());

        // Act
        $paginaInicial = new PaginaInicial($driver);
        $paginaInicial->visita();


        // Assert
        self::assertStringContainsString('Séries', $paginaInicial->obtemTextoH1());

        $driver->close();

    }
}