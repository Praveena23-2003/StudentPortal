<?php

use PHPUnit\Framework\TestCase;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverBy;

class StudentPortalProductTest extends TestCase
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

    public function testStudentPortalProducts()
    {
        $this->driver->get($this->baseUrl);

        $username = 'your_username';
        $password = 'your_password';

        $this->driver->findElement(WebDriverBy::id('username'))->sendKeys($username);
        $this->driver->findElement(WebDriverBy::id('password'))->sendKeys($password);
        $this->driver->findElement(WebDriverBy::id('login-button'))->click();

        $this->assertEquals($this->baseUrl . 'dashboard.php', $this->driver->getCurrentURL());

        // Wait for products to load
        $this->driver->wait(10)->until(
            WebDriverBy::className('inventory_item_name')
        );

        // Find all product elements
        $productLabels = $this->driver->findElements(WebDriverBy::className('inventory_item_name'));

        // Extract product names
        $productNames = [];
        foreach ($productLabels as $productLabel) {
            $productNames[] = $productLabel->getText();
        }

        // Print the product names
        foreach ($productNames as $productName) {
            echo $productName . "\n";
        }
    }
}
