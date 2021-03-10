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

    public function preencheCom(string $genero, string $qtdTemporada, string $nome = null, string $episodios = null)
    {
        $seletorGenero  = new WebDriverSelect($this->driver->findElement(WebDriverBy::id('genre')));
        $seletorGenero->selectByValue($genero);
        $this->driver->findElement(WebDriverBy::id('qtd_temporadas'))->sendKeys($qtdTemporada);

        if (!empty($nome)) {
            $this->driver->findElement(WebDriverBy::id('nome'))->sendKeys($nome);
        }

        if (!empty($episodios)) {
            $this->driver->findElement(WebDriverBy::id('ep_por_temporada'))->sendKeys($episodios);
        }

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