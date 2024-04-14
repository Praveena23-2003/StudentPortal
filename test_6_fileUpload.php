<?php

use PHPUnit\Framework\TestCase;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverExpectedCondition;

class StudentPortalFileUploadTest extends TestCase
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

    public function testStudentPortalFileUpload()
    {
        $this->driver->get($this->baseUrl);

        $username = 'your_username';
        $password = 'your_password';

        $this->driver->findElement(WebDriverBy::id('username'))->sendKeys($username);
        $this->driver->findElement(WebDriverBy::id('password'))->sendKeys($password);
        $this->driver->findElement(WebDriverBy::id('login-button'))->click();

        $this->assertEquals($this->baseUrl . 'dashboard.php', $this->driver->getCurrentURL());

        // Navigate to the file upload page
        $this->driver->get($this->baseUrl . 'upload.php');

        // Wait for the file input element to be visible
        $this->driver->wait(10)->until(
            WebDriverExpectedCondition::visibilityOfElementLocated(WebDriverBy::id('file-upload'))
        );

        // Locate the file input element using its "id" attribute
        $fileInput = $this->driver->findElement(WebDriverBy::id('file-upload'));

        // Specify the path to the file you want to upload
        $filePath = "/path/to/your/file.txt"; // Replace with the actual file path

        // Send the file path to the file input element
        $fileInput->sendKeys($filePath);

        // Locate and click the "Upload" button
        $uploadButton = $this->driver->findElement(WebDriverBy::id('file-submit'));
        $uploadButton->click();

        // Optionally, add verification steps to ensure the file was successfully uploaded
        // For example, you could check if a success message is displayed after uploading the file

        // Wait for some time to observe the result
        sleep(5);
    }
}
