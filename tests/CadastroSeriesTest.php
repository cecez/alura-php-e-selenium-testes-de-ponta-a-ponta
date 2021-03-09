<?php

use Alura\E2E\Tests\PageObject\PaginaLogin;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverSelect;
use PHPUnit\Framework\TestCase;

class CadastroSeriesTest extends TestCase {

    private static RemoteWebDriver $driver;

    // locators extraídos
    private static WebDriverBy $adicionarSerieGenre;

    public static function setUpBeforeClass()
    {
        // preenche locators
        self::$adicionarSerieGenre  = WebDriverBy::id('genre');

        // Arrange
        self::$driver = RemoteWebDriver::create('http://localhost:4444/wd/hub', DesiredCapabilities::chrome());
        self::$driver->get('http://localhost:8000/adicionar-serie');

        // faz login
        $paginaLogin = new PaginaLogin(self::$driver);
        $paginaLogin->realizaLoginCom('email@example.com', '123');

    }

    protected function setUp()
    {
        self::$driver->get('http://localhost:8000/adicionar-serie');
    }

    public static function tearDownAfterClass()
    {
        // fecha navegador
        self::$driver->close();
    }

    public function testCadastrarNovaSerieSemNomeDeveGerarErro() {

        // Act
        $selectGenero   = self::$driver->findElement(self::$adicionarSerieGenre);
        $seletorGenero  = new WebDriverSelect($selectGenero);
        $seletorGenero->selectByValue('acao');
        self::$driver->findElement(WebDriverBy::id('qtd_temporadas'))->sendKeys('2');
        self::$driver->findElement(WebDriverBy::tagName('button'))->click();

        // Assert
        self::assertSame('http://localhost:8000/adicionar-serie', self::$driver->getCurrentURL());
        self::assertSame(self::$driver->findElement(WebDriverBy::id('nome'))->getAttribute('validationMessage'), 'Preencha este campo.');
    }


    public function testCadastrarNovaSerieDeveRedirecionarParaListagem()
    {

        // Act
        self::$driver->findElement(WebDriverBy::id('nome'))->sendKeys('Nome de série');
        self::$driver->findElement(WebDriverBy::id('qtd_temporadas'))->sendKeys('2');

        $inputEpisodios = self::$driver->findElement(WebDriverBy::id('ep_por_temporada'));
        $inputEpisodios->sendKeys('10');

        // obtém <select> e seleciona uma opção
        $selectGenero = self::$driver->findElement(self::$adicionarSerieGenre);
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
        self::assertSame('http://localhost:8000/series', self::$driver->getCurrentURL());
        // e que existe um texto de confirmação
        self::assertSame(
            'Série com suas respectivas temporadas e episódios adicionada.',
            trim(self::$driver->findElement(WebDriverBy::cssSelector('div.alert.alert-success'))->getText())
        );


    }

}