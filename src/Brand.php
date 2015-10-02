<?php
    class Brand
    {
        private $name;
        private $id;

        function __construct($name, $id = null)
        {
            $this->name = $name;
            $this->id = $id;
        }

        function getName()
        {
            return $this->name;
        }

        function setName($name)
        {
            $this->name = $name;
        }

        function getId()
        {
            return $this->id;
        }

        function setId($id)
        {
            $this->id = $id;
        }

        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO brands (name) VALUES ('{$this->getName()}');");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        function update($new_name)
        {
            $GLOBALS['DB']->exec("UPDATE brands SET name = '{$new_name}' WHERE id = {$this->getId()};");
            $this->setName($new_name);
        }

        function delete()
        {
            $GLOBALS['DB']->exec("DELETE FROM brands WHERE id = {$this->getId()};");
        }

        function addStore($store)
        {
            $GLOBALS['DB']->exec("INSERT INTO brands_stores (brand_id, store_id) VALUES ({$this->getId()}, {$store->getId()});");
        }

        function getStores()
        {
            $brand_stores = array();
            $db_stores = $GLOBALS['DB']->query("SELECT stores.* FROM
                brands JOIN brands_stores ON (brands.id = brands_stores.brand_id)
                       JOIN stores ON (brands_stores.store_id = stores.id)
                WHERE brands.id = {$this->getId()};");

            foreach ($db_stores as $store) {
                $found_store = Store::find($store['id']);
                array_push($brand_stores, $found_store);
            }
            return $brand_stores;
        }


        static function getAll()
        {
            $brands = array();
            $db_brands = $GLOBALS['DB']->query("SELECT * FROM brands;");
            foreach ($db_brands as $brand) {
                $name = $brand["name"];
                $id = $brand["id"];
                $found_brand = new Brand($name, $id);
                array_push($brands, $found_brand);
            }
            return $brands;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM brands;");
        }

        static function find($id)
        {
            $db_brands = Brand::getAll();
            foreach ($db_brands as $brand) {
                if ($id == $brand->getId()) {
                    return $brand;
                }
            }
            return null;
        }
    }
?>
