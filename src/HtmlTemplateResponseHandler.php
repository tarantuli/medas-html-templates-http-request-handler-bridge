<?php

declare(strict_types=1);

namespace Medas\HtmlTemplatesHttpRequestHandlerBridge;

use Medas\HtmlTemplates\TemplateCompiler;
use Medas\HttpRequestHandler\Request\Request;
use Medas\HttpRequestHandler\ResponseHandlerManager;
use Medas\HttpRequestHandler\ResponseHandlers\HtmlHandler;
use Medas\HttpRequestHandler\ResponseHandlers\ResponseHandler;
use Medas\HttpRequestHandler\ResponseTypes\Response;
use Medas\ServiceManager\Attributes\Service;

#[Service]
class HtmlTemplateResponseHandler extends HtmlHandler implements ResponseHandler
{
    public function __construct(
        private TemplateCompiler $templateCompiler,
    )
    {
    }

    public function priority(): int
    {
        return -4;
    }

    public function handleResponse(Request $request, Response $response, ResponseHandlerManager $manager): bool
    {
        if (!$response instanceof TemplateResponse) {
            return false;
        }

        if (!$this->isHtmlRequest($request)) {
            return false;
        }

        echo $this->templateCompiler->compile($response->template);

        return true;
    }
}
