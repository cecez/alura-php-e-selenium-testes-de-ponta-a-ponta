<?php


namespace Alura\E2E\Tests\PageObject;


use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverBy;

class PaginaLogin
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
    }

    public function realizaLoginCom(string $email, string $senha): void
    {
        $this->driver->get('http://localhost:8000/entrar');

        // faz login
        $this->driver->findElement(WebDriverBy::id('email'))->sendKeys($email);
        $this->driver->findElement(WebDriverBy::id('password'))->sendKeys($senha)->submit();
    }
}