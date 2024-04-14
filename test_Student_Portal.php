<?php

require 'vendor/autoload.php';

use PHPUnit\Framework\TestCase;
use Facebook\WebDriver\Remote\RemoteWebDriver;

class StudentPortalLaunchBrowserTest extends TestCase
{
    protected $driver;
    protected $baseUrl = 'http://localhost/Student_Portal/';

   public function setUp(): void
{
    $capabilities = \Facebook\WebDriver\Remote\DesiredCapabilities::chrome();
    $this->driver = RemoteWebDriver::create('http://localhost:4444/wd/hub', $capabilities);
}


    public function tearDown(): void
    {
        $this->driver->quit();
    }

    /**
     * @runInSeparateProcess
     */
    public function testLaunchBrowser()
    {
        $this->driver->get($this->baseUrl);

        // Optional: Add assertions to verify that the correct page is loaded
        $this->assertEquals($this->baseUrl, $this->driver->getCurrentURL());
    }
}
