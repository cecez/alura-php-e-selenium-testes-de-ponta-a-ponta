<?php


namespace Tests;


use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;

class PaginaInicialTest extends \PHPUnit\Framework\TestCase
{
    public function testPaginaInicialNaoLogadoDeveSerListagemDeSeries()
    {
        // Arrange
        $host   = 'http://localhost:4444/wd/hub';
        $driver = RemoteWebDriver::create($host, DesiredCapabilities::chrome());

        // Act
        $driver->navigate()->to(config('app.url'));

        // Assert
        self::assertStringContainsString('Séries', $driver->getPageSource());

    }
}