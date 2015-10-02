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
