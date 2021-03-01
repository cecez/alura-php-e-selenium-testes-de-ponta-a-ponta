<?php

use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverSelect;
use PHPUnit\Framework\TestCase;

class CadastroSeriesTest extends TestCase {

    private RemoteWebDriver $driver;

    protected function setUp()
    {
        // Arrange
        $host   = 'http://localhost:4444/wd/hub';
        $this->driver = RemoteWebDriver::create($host, DesiredCapabilities::chrome());
        $this->driver->get('http://localhost:8000/adicionar-serie');

        // faz login e navega
        $this->driver->findElement(WebDriverBy::id('email'))->sendKeys('email@example.com');
        $this->driver->findElement(WebDriverBy::id('password'))->sendKeys('123')->submit();
        $this->driver->get('http://localhost:8000/adicionar-serie');
    }

    protected function tearDown()
    {
        // fecha navegador
        $this->driver->close();
    }

    public function testCadastrarNovaSerieDeveRedirecionarParaListagem()
    {

        // Act
        $this->driver->findElement(WebDriverBy::id('nome'))->sendKeys('Nome de série');
        $this->driver->findElement(WebDriverBy::id('qtd_temporadas'))->sendKeys('2');

        $inputEpisodios = $this->driver->findElement(WebDriverBy::id('ep_por_temporada'));
        $inputEpisodios->sendKeys('10');

        // obtém <select> e seleciona uma opção
        $selectGenero = $this->driver->findElement(WebDriverBy::id('genre'));
        $seletorGenero = new WebDriverSelect($selectGenero);
        $seletorGenero->selectByValue('acao');

        // se for arquivo
        // $driver->findElement()->sendKeys('/caminho/do/arquivo.tmp');
        // se for <textarea>
        // talvez seja necessário dar clique no elemento para então entrar com o texto

        /**
         * Vimos como manipular <select>s e conversamos sobre alguns casos de campos mais complexos,
         * mas se você quiser entrar em detalhes sobre esse tipo de estudo, existe uma página em construção na
         * documentação: https://github.com/php-webdriver/php-webdriver/wiki/Select,-checkboxes,-radio-buttons
         *
         * Já sobre a parte de envio de arquivos, a documentação já está pronta e é bem simples:
         * https://github.com/php-webdriver/php-webdriver/wiki/Upload-a-file
         */

            // submete formulário
            $inputEpisodios->submit();

        // Assert
        self::assertSame('http://localhost:8000/series', $this->driver->getCurrentURL());
        // e que existe um texto de confirmação
        self::assertSame(
            'Série com suas respectivas temporadas e episódios adicionada.',
            trim($this->driver->findElement(WebDriverBy::cssSelector('div.alert.alert-success'))->getText())
        );


    }

}