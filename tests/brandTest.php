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
            $this->assertEquals([$test_Brand], $result);
        }

        function testUpdate()
        {
            // Arrange
            $brand_name = "Babbling Brooks";
            $test_Brand = new Brand($brand_name);
            $test_Brand->save();

            $new_name = "Gibberish Producing Brooks";

            // Act
            $test_Store->update($new_name);
            $result = $test_Store->getName();

            // Assert
            $this->assertEquals($new_name, $result);

        }

        function testDelete()
        {
            // Arrange
            $name = "Babbling Brooks";
            $test_Brand = new Brand($name);
            $test_Brand->save();
            $name2 = "Old Balance";
            $test_Brand2 = new Brand($name2);
            $test_Brand2->save();

            // Act
            $test_Brand->delete();
            $result = Brand::getAll();

            // Assert
            $this->assertEquals([$test_Brand2], $result);
        }


        function testAddStore()
        {
            // Arrange
            $brand_name = "Babbling Brooks";
            $test_Brand = new Brand($brand_name);
            $test_Brand->save();

            $store_name = "I Wanna Run Fast Co.";
            $test_Store = new Store($store_name);
            $test_Store->save();

            // Act
            $test_Brand->addStore($test_Store);
            $result = $test_Brand->getStores();

            // Assert
            $this->assertEquals([$test_Store], $result);
        }

        function testGetStores()
        {
            // Arrange
            $brand_name = "Babbling Brooks";
            $test_Brand = new Brand($brand_name);
            $test_Brand->save();

            $store_name = "Get Your Kicks Co.";
            $test_Store = new Store($store_name);
            $test_Store->save();


            $store_name2 = "I Wanna Run Fast Co.";
            $test_Store2 = new Store($store_name2);
            $test_Store2->save();

            // Act
            $test_Brand->addStore($test_Store);
            $test_Brand->addStore($test_Store2);
            $result = $test_Brand->getStores();

            // Assert
            $this->assertEquals([$test_Store, $test_Store2], $result);
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
