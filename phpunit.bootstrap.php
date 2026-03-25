<?php

declare(strict_types=1);

use Medas\HtmlTemplatesHttpRequestHandlerBridge\HtmlTemplatesHttpRequestHandlerBridgePackage;
use Medas\ObjectInstantiator\ObjectInstantiator;
use Medas\ObjectInstantiator\ObjectInstantiatorPackage;
use Medas\ServiceManager\{ServiceConfig, ServiceManager};

chdir(__DIR__);

new ServiceManager(function (): ServiceConfig {
    $config = new ServiceConfig(ObjectInstantiator::class);

    $config->addPackages([
        HtmlTemplatesHttpRequestHandlerBridgePackage::instance(),
        ObjectInstantiatorPackage::instance(),
    ]);

    return $config;
});
