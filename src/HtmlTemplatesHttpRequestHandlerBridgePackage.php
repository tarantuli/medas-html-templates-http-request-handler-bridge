<?php

declare(strict_types=1);

namespace Medas\HtmlTemplatesHttpRequestHandlerBridge;

use Medas\HtmlTemplates\HtmlTemplatesPackage;
use Medas\HttpRequestHandler\HttpRequestHandlerPackage;
use Medas\ServiceManager\{AsSingleton, BasePackage};

class HtmlTemplatesHttpRequestHandlerBridgePackage extends BasePackage
{
    use AsSingleton;

    public function dependencies(): array
    {
        return $this->dependenciesByClass([
            HtmlTemplatesPackage::class,
            HttpRequestHandlerPackage::class,
        ]);
    }

    public function sourceDirectory(): string
    {
        return __DIR__;
    }
}
