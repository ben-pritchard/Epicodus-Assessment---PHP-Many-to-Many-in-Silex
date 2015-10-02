<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Brand.php";
    require_once "src/Store.php";

    $server = 'mysql:host=localhost;dbname=shoes_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class BrandTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Brand::deleteAll();
            // Store::deleteAll();
        }

        function testGetName()
        {
            // Arrange
            $name = "Babbling Brooks";
            $test_Brand = new Brand($name);

            // Act
            $result = $test_Brand->getName();

            // Assert
            $this->assertEquals($name, $result);
        }

        function testGetId()
        {
            // Arrange
            $name = "Babbling Brooks";
            $id = 123456789;
            $test_Brand = new Brand($name, $id);

            // Act
            $result = $test_Brand->getId();

            // Assert
            $this->assertEquals($id, $result);
        }

        function testSave()
        {
            // Arrange
            $name = "Babbling Brooks";
            $test_Brand = new Brand($name);
            $test_Brand->save();

            // Act
            $result = Brand::getAll();

            // Assert
            $this->assertEquals($test_Brand, $result[0]);
        }

        function testGetAll()
        {
            // Arrange
            $name = "Babbling Brooks";
            $test_Brand = new Brand($name);
            $test_Brand->save();
            $name2 = "Old Balance";
            $test_Brand2 = new Brand($name2);
            $test_Brand2->save();

            // Act
            $result = Brand::getAll();

            // Assert
            $this->assertEquals([$test_Brand, $test_Brand2], $result);
        }

        function testDeleteAll()
        {
            // Arrange
            $name = "Babbling Brooks";
            $test_Brand = new Brand($name);
            $test_Brand->save();
            $name2 = "Old Balance";
            $test_Brand2 = new Brand($name2);
            $test_Brand2->save();

            // Act
            Brand::deleteAll();
            $result = Brand::getAll();

            // Assert
            $this->assertEquals([], $result);
        }

        function testFind()
        {
            // Arrange
            $name = "Babbling Brooks";
            $test_Brand = new Brand($name);
            $test_Brand->save();
            $name2 = "Old Balance";
            $test_Brand2 = new Brand($name2);
            $test_Brand2->save();

            // Act
            $result = Brand::find($test_Brand2->getId());

            // Assert
            $this->assertEquals($test_Brand2, $result);

        }
    }

?>
