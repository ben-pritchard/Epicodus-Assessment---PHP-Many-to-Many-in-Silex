<?php
    class Store
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
            $GLOBALS['DB']->exec("INSERT INTO stores (name) VALUES ('{$this->getName()}');");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        function update($new_name)
        {
            $GLOBALS['DB']->exec("UPDATE stores SET name = '{$new_name}' WHERE id = {$this->getId()};");
            $this->setName($new_name);
        }

        function delete()
        {
            $GLOBALS['DB']->exec("DELETE FROM stores WHERE id = {$this->getId()};");
        }

        function addBrand($brand)
        {
            $GLOBALS['DB']->exec("INSERT INTO brands_stores (brand_id, store_id) VALUES ({$brand->getId()}, {$this->getId()});");
        }

        function getBrands()
        {
            $query = $GLOBALS['DB']->query("SELECT brand_id FROM brands_stores WHERE store_id = {$this->getId()};");
            $db_brand_ids = $query->fetchAll(PDO::FETCH_ASSOC);

            $store_brands = array();
            foreach ($db_brand_ids as $db_brand_id) {
                $brand = Brand::find($db_brand_id['brand_id']);
                array_push($store_brands, $brand);
            }
            return $store_brands;
        }

        static function getAll()
        {
            $stores = array();
            $db_stores = $GLOBALS['DB']->query("SELECT * FROM stores;");
            foreach ($db_stores as $store) {
                $name = $store["name"];
                $id = $store["id"];
                $found_store = new Store($name, $id);
                array_push($stores, $found_store);
            }
            return $stores;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM stores;");
        }

        static function find($id)
        {
            $db_stores = Store::getAll();
            foreach ($db_stores as $store) {
                if ($id == $store->getId()) {
                    return $store;
                }
            }
            return null;
        }
    }
?>
