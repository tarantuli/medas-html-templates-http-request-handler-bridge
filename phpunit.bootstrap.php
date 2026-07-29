<?php

declare(strict_types=1);

use Medas\HtmlTemplatesHttpRequestHandlerBridge\HtmlTemplatesHttpRequestHandlerBridgePackage;
use Medas\ObjectInstantiator\{ObjectInstantiator, ObjectInstantiatorPackage};
use Medas\ServiceManager\{ServiceConfigBuilder, ServiceManager};

chdir(__DIR__);

new ServiceManager(function (): ServiceConfigBuilder {
    $config = new ServiceConfigBuilder(ObjectInstantiator::class);

    $config->addPackages([
        HtmlTemplatesHttpRequestHandlerBridgePackage::instance(),
        ObjectInstantiatorPackage::instance(),
    ]);

    return $config;
});
