<?php
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Brand.php";
    require_once __DIR__."/../src/Store.php";

    //Add symfony debug component and turn it on.
    use Symfony\Component\Debug\Debug;
    Debug::enable();

    $app = new Silex\Application();

    // Set Silex debug mode in $app object
    $app['debug'] = true;

    $server = 'mysql:host=localhost;dbname=shoes';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    $app->register(new Silex\Provider\TwigServiceProvider(), array(
        'twig.path' => __DIR__.'/../views'
    ));

    $app->get("/", function() use ($app) {
        return $app['twig']->render('index.html.twig', array('stores' => Store::getAll(), 'brands' => Brand::getAll()));
    });

    $app->get("/stores/{id}", function($id) use ($app) {
        $store = Store::find($id);
        return $app['twig']->render('store.html.twig', array('store' => $store, 'store_brands' => $store->getBrands()));
    });

    $app->post("/add_store", function() use ($app) {
        $new_store = new Store($_POST['name']);
        $new_store->save();
        return $app['twig']->render('index.html.twig', array('stores' => Store::getAll(), 'brands' => Brand::getAll()));
    });

    $app->post("/add_stores", function() use ($app) {
        $brand = Brand::find($_POST['brand_id']);
        $store = new Store($_POST['name']);
        $store->save();
        $brand->addStore($store);
        return $app['twig']->render('brand.html.twig', array('brand' => $brand, 'brand_stores' => $brand->getStores()));
    });

    $app->get("/stores/{id}/edit", function($id) use ($app) {
        $store = Store::find($id);
        return $app['twig']->render('store_edit.html.twig', array('store' => $store));
    });

    $app->post("/stores/{id}", function($id) use ($app) {
        $store = Store::find($id);
        $new_name = $_POST['name'];
        $store->update($new_name);
        return $app['twig']->render('store.html.twig', array('store' => $store, 'store_brands' => $store->getBrands()));
    });

    $app->post("/delete_store/{id}", function($id) use ($app) {
        $store = Store::find($id);
        $store->delete();
        return $app['twig']->render('index.html.twig', array('stores' => Store::getAll(), 'brands' => Brand::getAll()));
    });

    $app->post("/delete_stores", function() use ($app) {
        Store::deleteAll();
        return $app['twig']->render('index.html.twig', array('stores' => Store::getAll(), 'brands' => Brand::getAll()));
    });

    $app->get("/brands/{id}", function($id) use ($app) {
        $brand = Brand::find($id);
        return $app['twig']->render('brand.html.twig', array('brand' => $brand, 'brand_stores' => $brand->getStores()));
    });

    $app->post("/add_brand", function() use ($app) {
        $new_brand = new Brand($_POST['name']);
        $new_brand->save();
        return $app['twig']->render('index.html.twig', array('stores' => Store::getAll(), 'brands' => Brand::getAll()));
    });

    $app->post("/add_brands", function() use ($app) {
        $store = Store::find($_POST['store_id']);
        $brand = new Brand($_POST['name']);
        $brand->save();
        $store->addBrand($brand);
        return $app['twig']->render('store.html.twig', array('store' => $store, 'store_brands' => $store->getBrands()));
    });

    $app->post("/delete_brand/{id}", function($id) use ($app) {
        $brand = Brand::find($id);
        $brand->delete();
        return $app['twig']->render('index.html.twig', array('stores' => Store::getAll(), 'brands' => Brand::getAll()));
    });

    $app->post("/delete_brands", function() use ($app) {
        Brand::deleteAll();
        return $app['twig']->render('index.html.twig', array('stores' => Store::getAll(), 'brands' => Brand::getAll()));
    });

    return $app;
?>
