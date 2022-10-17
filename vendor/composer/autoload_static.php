<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit4a63e917d6cff490d08fb3bbc876ef03
{
    public static $classMap = array (
        'ComposerAutoloaderInit4a63e917d6cff490d08fb3bbc876ef03' => __DIR__ . '/..' . '/composer/autoload_real.php',
        'Composer\\Autoload\\ClassLoader' => __DIR__ . '/..' . '/composer/ClassLoader.php',
        'Composer\\Autoload\\ComposerStaticInit4a63e917d6cff490d08fb3bbc876ef03' => __DIR__ . '/..' . '/composer/autoload_static.php',
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
        'Model\\Order' => __DIR__ . '/../..' . '/Model/Order.php',
        'Model\\OrderBuilder' => __DIR__ . '/../..' . '/Model/OrderBuilder.php',
        'Model\\Product' => __DIR__ . '/../..' . '/Model/Product.php',
        'Model\\ProductBuilder' => __DIR__ . '/../..' . '/Model/ProductBuilder.php',
        'Model\\Products\\Fridge' => __DIR__ . '/../..' . '/Model/Products/Fridge.php',
        'Model\\Products\\FridgeBuilder' => __DIR__ . '/../..' . '/Model/Products/FridgeBuilder.php',
        'Model\\Products\\Laptop' => __DIR__ . '/../..' . '/Model/Products/Laptop.php',
        'Model\\Products\\LaptopBuilder' => __DIR__ . '/../..' . '/Model/Products/LaptopBuilder.php',
        'Model\\Products\\Phone' => __DIR__ . '/../..' . '/Model/Products/Phone.php',
        'Model\\Products\\PhoneBuilder' => __DIR__ . '/../..' . '/Model/Products/PhoneBuilder.php',
        'Model\\Products\\TV' => __DIR__ . '/../..' . '/Model/Products/TV.php',
        'Model\\Products\\TVBuilder' => __DIR__ . '/../..' . '/Model/Products/TVBuilder.php',
        'Model\\Service' => __DIR__ . '/../..' . '/Model/Service.php',
        'Model\\ServiceBuilder' => __DIR__ . '/../..' . '/Model/ServiceBuilder.php',
        'Model\\Services\\Configure' => __DIR__ . '/../..' . '/Model/Services/Configure.php',
        'Model\\Services\\ConfigureBuilder' => __DIR__ . '/../..' . '/Model/Services/ConfigureBuilder.php',
        'Model\\Services\\Delivery' => __DIR__ . '/../..' . '/Model/Services/Delivery.php',
        'Model\\Services\\DeliveryBuilder' => __DIR__ . '/../..' . '/Model/Services/DeliveryBuilder.php',
        'Model\\Services\\Install' => __DIR__ . '/../..' . '/Model/Services/Install.php',
        'Model\\Services\\InstallBuilder' => __DIR__ . '/../..' . '/Model/Services/InstallBuilder.php',
        'Model\\Services\\Warranty' => __DIR__ . '/../..' . '/Model/Services/Warranty.php',
        'Model\\Services\\WarrantyBuilder' => __DIR__ . '/../..' . '/Model/Services/WarrantyBuilder.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->classMap = ComposerStaticInit4a63e917d6cff490d08fb3bbc876ef03::$classMap;

        }, null, ClassLoader::class);
    }
}
