<?php


namespace Tests\PageObject;


use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverSelect;

class PaginaCadastroDeUsuario
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
        $this->driver->get('http://localhost:8000/novo-usuario');
    }

    public function preencheNome(string $nome): self
    {
        $this->driver->findElement(WebDriverBy::id('name'))->sendKeys($nome);

        return $this;
    }

    public function submeteFormulario()
    {
        $this->driver->findElement(WebDriverBy::tagName('button'))->click();
    }

    public function obtemLinkSair()
    {
        return $this->driver->findElement(WebDriverBy::linkText('Sair'));
    }

    public function preencheEmail(string $email)
    {
        $this->driver->findElement(WebDriverBy::id('email'))->sendKeys($email);
    }

    public function preencheSenha(string $senha)
    {
        $this->driver->findElement(WebDriverBy::id('password'))->sendKeys($senha);
    }
}