<?php

use PHPUnit\Framework\TestCase;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\Interactions\Actions;

class StudentPortalDragAndDropTest extends TestCase
{
    protected $driver;
    protected $baseUrl = 'http://localhost/Student_Portal/';

    protected function setUp(): void
    {
        $capabilities = \Facebook\WebDriver\Remote\DesiredCapabilities::chrome();
        $this->driver = RemoteWebDriver::create('http://localhost:4444/wd/hub', $capabilities);
    }

    protected function tearDown(): void
    {
        $this->driver->quit();
    }

    public function testStudentPortalDragAndDrop()
    {
        $this->driver->get($this->baseUrl);

        $username = 'your_username';
        $password = 'your_password';

        $this->driver->findElement(WebDriverBy::id('username'))->sendKeys($username);
        $this->driver->findElement(WebDriverBy::id('password'))->sendKeys($password);
        $this->driver->findElement(WebDriverBy::id('login-button'))->click();

        $this->assertEquals($this->baseUrl . 'dashboard.php', $this->driver->getCurrentURL());

        // Wait for the drag and drop elements to be visible
        $this->driver->wait(10)->until(
            WebDriverBy::id('column-a')
        );

        // Locate the source and target elements for drag and drop
        $sourceElement = $this->driver->findElement(WebDriverBy::id('column-a'));
        $targetElement = $this->driver->findElement(WebDriverBy::id('column-b'));

        // Perform the drag and drop action
        $actions = new Actions($this->driver);
        $actions->dragAndDrop($sourceElement, $targetElement)->perform();
        sleep(2);
        $actions->dragAndDrop($targetElement, $sourceElement)->perform();
        sleep(2);
    }
}
