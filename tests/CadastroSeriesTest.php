<?php

use Tests\PageObject\PaginaCadastroDeSerie;
use Tests\PageObject\PaginaLogin;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverBy;
use PHPUnit\Framework\TestCase;

class CadastroSeriesTest extends TestCase {

    private static RemoteWebDriver $driver;

    // locators extraídos
    private static WebDriverBy $adicionarSerieGenre;

    private PaginaCadastroDeSerie $paginaCadastroDeSerie;

    public static function setUpBeforeClass()
    {
        // preenche locators
        self::$adicionarSerieGenre  = WebDriverBy::id('genre');

        // Arrange
        self::$driver = RemoteWebDriver::create('http://localhost:4444/wd/hub', DesiredCapabilities::chrome());

        // faz login
        $paginaLogin = new PaginaLogin(self::$driver);
        $paginaLogin->realizaLoginCom('email@example.com', '123');

    }

    protected function setUp()
    {
        $this->paginaCadastroDeSerie = new PaginaCadastroDeSerie(self::$driver);
    }

    public static function tearDownAfterClass()
    {
        // fecha navegador
        self::$driver->close();
    }

    public function testCadastrarNovaSerieSemNomeDeveGerarErro()
    {
        // Act
        $this->paginaCadastroDeSerie->preencheGenero('acao')
                                    ->preencheTemporadas(2)
                                    ->submeteFormulario();

        // Assert
        self::assertSame('http://localhost:8000/adicionar-serie', self::$driver->getCurrentURL());
        self::assertSame($this->paginaCadastroDeSerie->obtemMensagemDeValidacao(), 'Preencha este campo.');
    }

    public function testCadastrarNovaSerieDeveRedirecionarParaListagem()
    {
        // Act
        $this->paginaCadastroDeSerie->preencheNome('Nome de série ' . date('dmYis'))
                                    ->preencheTemporadas(3)
                                    ->preencheGenero('acao')
                                    ->preencheEspisodios(12)
                                    ->submeteFormulario();

        // Assert
        self::assertSame('http://localhost:8000/series', self::$driver->getCurrentURL());
        // e que existe um texto de confirmação
        self::assertSame(
            'Série com suas respectivas temporadas e episódios adicionada.',
            $this->paginaCadastroDeSerie->obtemMensagemDeRetornoOk()
        );


    }

}