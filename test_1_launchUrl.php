<?php

use PHPUnit\Framework\TestCase;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverExpectedCondition;

class StudentPortalLoginTest extends TestCase
{
    protected $driver;

    protected function setUp(): void
    {
        // Set up Chrome WebDriver
        $this->driver = RemoteWebDriver::create('http://localhost:4444/wd/hub', \Facebook\WebDriver\WebDriverCapabilityType::BROWSER_NAME, 'chrome');
    }

    protected function tearDown(): void
    {
        // Close the browser
        $this->driver->quit();
    }

    public function testStudentPortalLogin()
    {
        // Open the Student Portal login page
        $this->driver->get('http://localhost/Student_Portal/login.php');

        // Find the login form elements
        $username_input = $this->driver->findElement(WebDriverBy::name('username'));
        $password_input = $this->driver->findElement(WebDriverBy::name('password'));
        $login_button = $this->driver->findElement(WebDriverBy::xpath('//input[@type="submit"]'));

        // Input login credentials
        $username_input->sendKeys('your_username');
        $password_input->sendKeys('your_password');

        // Click the login button
        $login_button->click();

        // Wait for the dashboard URL to load
        $this->driver->wait()->until(WebDriverExpectedCondition::urlContains('dashboard'));

        // Verify successful login by checking the URL
        $this->assertStringContainsString('dashboard', $this->driver->getCurrentURL());
    }
}
