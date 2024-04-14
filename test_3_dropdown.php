<?php

use PHPUnit\Framework\TestCase;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverSelect;

class StudentPortalDropdownTest extends TestCase
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

    public function testStudentPortalDropdown()
    {
        $this->driver->get($this->baseUrl);

        $username = 'your_username';
        $password = 'your_password';

        $this->driver->findElement(WebDriverBy::id('username'))->sendKeys($username);
        $this->driver->findElement(WebDriverBy::id('password'))->sendKeys($password);
        $this->driver->findElement(WebDriverBy::id('login-button'))->click();

        $this->assertEquals($this->baseUrl . 'dashboard.php', $this->driver->getCurrentURL());

        // Wait for the dropdown element to be visible
        $this->driver->wait(10)->until(
            WebDriverBy::id('dropdown')
        );

        // Locate the dropdown element
        $dropdown = new WebDriverSelect($this->driver->findElement(WebDriverBy::id('dropdown')));

        // Select an option by value
        $dropdown->selectByValue('1');  // Replace '1' with the desired option value
        sleep(2);
        $dropdown->selectByValue('2');
        sleep(2);
        $dropdown->selectByIndex(1);

        // Alternatively, select an option by visible text
        // $dropdown->selectByVisibleText('Option 2');

        // Get the selected option
        $selectedOption = $dropdown->getFirstSelectedOption();

        // Get the value and text of the selected option
        $selectedValue = $selectedOption->getAttribute('value');
        $selectedText = $selectedOption->getText();

        echo $selectedText . "\n";
    }
}
