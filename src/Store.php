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
