<?php

use PHPUnit\Framework\TestCase;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverExpectedCondition;

class StudentPortalTablesTest extends TestCase
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

    public function testVerifyFirstTableData()
    {
        $this->driver->get($this->baseUrl . 'tables.php'); // Adjust URL according to your project

        // Wait for the first table to be visible
        $this->driver->wait(10)->until(
            WebDriverExpectedCondition::visibilityOfElementLocated(WebDriverBy::id('table1'))
        );

        // Find the first table
        $table1 = $this->driver->findElement(WebDriverBy::id('table1'));

        // Find all rows in the table
        $rows = $table1->findElements(WebDriverBy::tagName('tr'));

        // Iterate through the rows and print the data
        foreach ($rows as $row) {
            $columns = $row->findElements(WebDriverBy::tagName('td'));
            foreach ($columns as $column) {
                echo $column->getText() . "\n";
            }
        }
    }

    public function testVerifySecondTableData()
    {
        $this->driver->get($this->baseUrl . 'tables.php'); // Adjust URL according to your project

        // Wait for the second table to be visible
        $this->driver->wait(10)->until(
            WebDriverExpectedCondition::visibilityOfElementLocated(WebDriverBy::id('table2'))
        );

        // Find the second table
        $table2 = $this->driver->findElement(WebDriverBy::id('table2'));

        // Find all rows in the table
        $rows = $table2->findElements(WebDriverBy::tagName('tr'));

        // Iterate through the rows and print the data
        foreach ($rows as $row) {
            $columns = $row->findElements(WebDriverBy::tagName('td'));
            foreach ($columns as $column) {
                echo $column->getText() . "\n";
            }
        }
    }
}
