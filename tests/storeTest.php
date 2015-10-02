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

        function testUpdate()
        {
            // Arrange
            $name = "Get Your Kicks Co.";
            $test_Store = new Store($name);
            $test_Store->save();

            $new_name = "Get Your Kicks Yo";

            // Act
            $test_Store->update($new_name);
            $result = $test_Store->getName();

            // Assert
            $this->assertEquals($new_name, $result);

        }

        function testDelete()
        {
            // Arrange
            $name = "Get Your Kicks Co.";
            $test_Store = new Store($name);
            $test_Store->save();
            $name2 = "I Wanna Run Fast Co.";
            $test_Store2 = new Store($name2);
            $test_Store2->save();

            // Act
            $test_Store->delete();
            $result = Store::getAll();

            // Assert
            $this->assertEquals([$test_Store2], $result);

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

        function testAddBrand()
        {
            // Arrange
            $brand_name = "Babbling Brooks";
            $test_Brand = new Brand($brand_name);
            $test_Brand->save();

            $store_name = "I Wanna Run Fast Co.";
            $test_Store = new Store($store_name);
            $test_Store->save();

            // Act
            $test_Store->addBrand($test_Brand);
            $result = $test_Store->getBrands();

            // Assert
            $this->assertEquals([$test_Brand], $result);
        }

        function testGetBrands()
        {
            // Arrange
            $brand_name = "Babbling Brooks";
            $test_Brand = new Brand($brand_name);
            $test_Brand->save();

            $brand_name2 = "Old Balance";
            $test_Brand2 = new Brand($brand_name2);
            $test_Brand2->save();


            $store_name = "I Wanna Run Fast Co.";
            $test_Store = new Store($store_name);
            $test_Store->save();

            // Act
            $test_Store->addBrand($test_Brand);
            $test_Store->addBrand($test_Brand2);
            $result = $test_Store->getBrands();

            // Assert
            $this->assertEquals([$test_Brand, $test_Brand2], $result);
        }
    }

?>
