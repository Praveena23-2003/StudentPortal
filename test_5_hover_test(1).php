<?php

use PHPUnit\Framework\TestCase;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\Interactions\Actions;

class StudentPortalHoverTest extends TestCase
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

    /**
     * @dataProvider profileIndexProvider
     */
    public function testStudentPortalHover($profileIndex)
    {
        $this->driver->get($this->baseUrl);

        $username = 'your_username';
        $password = 'your_password';

        $this->driver->findElement(WebDriverBy::id('username'))->sendKeys($username);
        $this->driver->findElement(WebDriverBy::id('password'))->sendKeys($password);
        $this->driver->findElement(WebDriverBy::id('login-button'))->click();

        $this->assertEquals($this->baseUrl . 'dashboard.php', $this->driver->getCurrentURL());

        // Wait for the profile elements to be visible
        $this->driver->wait(10)->until(
            WebDriverBy::className('figure')
        );

        // Find all profile elements
        $profileElements = $this->driver->findElements(WebDriverBy::className('figure'));

        // Hover over the specified profile element
        $profileElement = $profileElements[$profileIndex - 1];
        $actions = new Actions($this->driver);
        $actions->moveToElement($profileElement)->perform();

        // Get the name associated with the hovered element
        $name = $profileElement->findElement(WebDriverBy::tagName('h5'))->getText();
        echo "Name: $name\n";

        // Optionally, add assertions to validate the expected behavior
        $this->assertStringContainsString('user', strtolower($name));  // Example assertion: Check if "user" is in the name
    }

    public function profileIndexProvider()
    {
        return [
            [1],
            [2],
            [3]
        ];
    }
}
