<?php


namespace Tests\PageObject;


use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverSelect;

class PaginaCadastroDeSerie
{
    /**
     * @var RemoteWebDriver
     */
    private RemoteWebDriver $driver;

    /**
     * PaginaLogin constructor.
     * @param  RemoteWebDriver  $driver
     */
    public function __construct(RemoteWebDriver $driver)
    {
        $this->driver = $driver;
        $this->driver->get('http://localhost:8000/adicionar-serie');
    }

    public function preencheGenero(string $genero): self
    {
        $seletorGenero  = new WebDriverSelect($this->driver->findElement(WebDriverBy::id('genre')));
        $seletorGenero->selectByValue($genero);

        return $this;
    }

    public function preencheTemporadas(int $qtdTemporadas): self
    {
        $this->driver->findElement(WebDriverBy::id('qtd_temporadas'))->sendKeys($qtdTemporadas);

        return $this;
    }

    public function preencheNome(string $nome): self
    {
        $this->driver->findElement(WebDriverBy::id('nome'))->sendKeys($nome);

        return $this;
    }

    public function preencheEspisodios(int $episodios): self
    {
        $this->driver->findElement(WebDriverBy::id('ep_por_temporada'))->sendKeys($episodios);

        return $this;
    }

    public function submeteFormulario()
    {
        $this->driver->findElement(WebDriverBy::tagName('button'))->click();
    }

    public function obtemMensagemDeValidacao()
    {
        return $this->driver->findElement(WebDriverBy::id('nome'))->getAttribute('validationMessage');
    }

    public function obtemMensagemDeRetornoOk()
    {
        return trim($this->driver->findElement(WebDriverBy::cssSelector('div.alert.alert-success'))->getText());
    }
}