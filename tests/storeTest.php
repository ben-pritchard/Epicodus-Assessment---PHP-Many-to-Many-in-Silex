<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Store.php";
    require_once "src/Brand.php";

    $server = 'mysql:host=localhost;dbname=shoes_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class StoreTest extends PHPUnit_Framework_TestCase
    {
        // protected function tearDown()
        // {
        //     Store::deleteAll();
        //     Brand::deleteAll();
        // }

        function testGetName()
        {
            // Arrange
            $name = "Portland Running Co.";
            $test_Store = new Store($name);

            // Act
            $result = $test_Store->getName();

            // Assert
            $this->assertEquals($name, $result);
        }
    }

?>
