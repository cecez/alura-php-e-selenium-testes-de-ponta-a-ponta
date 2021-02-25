<?php

use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverSelect;
use PHPUnit\Framework\TestCase;

class CadastroSeriesTest extends TestCase {

    public function testCadastrarNovaSerieDeveRedirecionarParaListagem()
    {
        // Arrange
        $host   = 'http://localhost:4444/wd/hub';
        $driver = RemoteWebDriver::create($host, DesiredCapabilities::chrome());
        $driver->get('http://localhost:8000/adicionar-serie');

            // faz login e navega
            $driver->findElement(WebDriverBy::id('email'))->sendKeys('email@example.com');
            $driver->findElement(WebDriverBy::id('password'))->sendKeys('123')->submit();
            $driver->get('http://localhost:8000/adicionar-serie');

        // Act
        $driver->findElement(WebDriverBy::id('nome'))->sendKeys('Nome de série');
        $driver->findElement(WebDriverBy::id('qtd_temporadas'))->sendKeys('2');

        $inputEpisodios = $driver->findElement(WebDriverBy::id('ep_por_temporada'));
        $inputEpisodios->sendKeys('10');

        // obtém <select> e seleciona uma opção
        $selectGenero = $driver->findElement(WebDriverBy::id('genre'));
        $seletorGenero = new WebDriverSelect($selectGenero);
        $seletorGenero->selectByValue('acao');

            // submete formulário
            $inputEpisodios->submit();

        // Assert
        self::assertSame('http://localhost:8000/series', $driver->getCurrentURL());
        // e que existe um texto de confirmação
        self::assertSame(
            'Série com suas respectivas temporadas e episódios adicionada.',
            trim($driver->findElement(WebDriverBy::cssSelector('div.alert.alert-success'))->getText())
        );
    }

}