<?php


namespace Tests\PageObject;


use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverExpectedCondition;

class PaginaInicial
{

    private RemoteWebDriver $driver;

    public function __construct($driver)
    {
        $this->driver = $driver;
    }

    public function visita()
    {
        $this->driver->navigate()->to('http://localhost:8000');
    }

    public function obtemTextoH1()
    {
        $h1Locator  = WebDriverBy::tagName('h1');

        return $this->driver->findElement($h1Locator)->getText();
    }

    public function clicaParaEditarSeriadoDeId(int $idSerieParaAlterar): self
    {
        $elementoLi = $this->driver->findElement(WebDriverBy::cssSelector("li[data-serie-id='$idSerieParaAlterar']"));
        $elementoLi->findElement(WebDriverBy::cssSelector('button.btn-info'))->click();

        return $this;
    }

    public function defineNomeDoSeriadoDeId(int $idSerieParaAlterar, string $nomeSerieAlterada): self
    {
        $elementoLi = $this->driver->findElement(WebDriverBy::cssSelector("li[data-serie-id='$idSerieParaAlterar']"));
        $elementoLi
            ->findElement(WebDriverBy::cssSelector("#input-nome-serie-$idSerieParaAlterar input"))
            ->clear()
            ->sendKeys($nomeSerieAlterada);

        return $this;
    }

    public function finalizaEdicaoDoSeriadoDeId(int $idSerieParaAlterar): void
    {
        $elementoLi = $this->driver->findElement(WebDriverBy::cssSelector("li[data-serie-id='$idSerieParaAlterar']"));
        $elementoLi
            ->findElement(WebDriverBy::cssSelector("#input-nome-serie-$idSerieParaAlterar button"))
            ->click();
    }

    public function nomeSeriadoDeId(int $idSerieParaAlterar): string
    {

        $seletorNomeDaSerie     = WebDriverBy::id("nome-serie-$idSerieParaAlterar");
        $elementoNomeDaSerie    = $this->driver->findElement($seletorNomeDaSerie);

        // aguarda até elemento ficar visível
        // mais detalhes em https://github.com/php-webdriver/php-webdriver/wiki/HowTo-Wait
        $this->driver->wait()->until(WebDriverExpectedCondition::visibilityOf($elementoNomeDaSerie));

        return $elementoNomeDaSerie->getText();
    }
}