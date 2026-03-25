<?php

declare(strict_types=1);

namespace Medas\HtmlTemplatesHttpRequestHandlerBridge;

use Medas\Core\{AsSingleton, BasePackage};
use Medas\HtmlTemplates\HtmlTemplatesPackage;
use Medas\HttpRequestHandler\HttpRequestHandlerPackage;

class HtmlTemplatesHttpRequestHandlerBridgePackage extends BasePackage
{
    use AsSingleton;

    public function dependencies(): array
    {
        return [
            HtmlTemplatesPackage::instance(),
            HttpRequestHandlerPackage::instance(),
        ];
    }

    public function sourceDirectory(): string
    {
        return __DIR__;
    }
}
