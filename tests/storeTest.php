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
        protected function tearDown()
        {
            Store::deleteAll();
            // Brand::deleteAll();
        }

        function testGetName()
        {
            // Arrange
            $name = "Get Your Kicks Co.";
            $test_Store = new Store($name);

            // Act
            $result = $test_Store->getName();

            // Assert
            $this->assertEquals($name, $result);
        }

        function testGetId()
        {
            // Arrange
            $name = "Get Your Kicks Co.";
            $id = 123456789;
            $test_Store = new Store($name, $id);

            // Act
            $result = $test_Store->getId();

            // Assert
            $this->assertEquals($id, $result);
        }

        function testSave()
        {
            // Arrange
            $name = "Get Your Kicks Co.";
            $test_Store = new Store($name);
            $test_Store->save();

            // Act
            $result = Store::getAll();

            // Assert
            $this->assertEquals($test_Store, $result[0]);
        }

        function testGetAll()
        {
            // Arrange
            $name = "Get Your Kicks Co.";
            $test_Store = new Store($name);
            $test_Store->save();
            $name2 = "I Wanna Run Fast Co.";
            $test_Store2 = new Store($name2);
            $test_Store2->save();

            // Act
            $result = Store::getAll();

            // Assert
            $this->assertEquals([$test_Store, $test_Store2], $result);
        }

        function testDeleteAll()
        {
            // Arrange
            $name = "Get Your Kicks Co.";
            $test_Store = new Store($name);
            $test_Store->save();
            $name2 = "I Wanna Run Fast Co.";
            $test_Store2 = new Store($name2);
            $test_Store2->save();

            // Act
            Store::deleteAll();
            $result = Store::getAll();

            // Assert
            $this->assertEquals([], $result);
        }

        function testFind()
        {
            // Arrange
            $name = "Get Your Kicks Co.";
            $test_Store = new Store($name);
            $test_Store->save();
            $name2 = "I Wanna Run Fast Co.";
            $test_Store2 = new Store($name2);
            $test_Store2->save();

            // Act
            $result = Store::find($test_Store2->getId());

            // Assert
            $this->assertEquals($test_Store2, $result);

        }
    }

?>
