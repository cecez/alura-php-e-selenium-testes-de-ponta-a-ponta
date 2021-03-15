<?php


namespace Tests\PageObject;


use Facebook\WebDriver\WebDriverBy;

class PaginaInicial
{

    private $driver;

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
}