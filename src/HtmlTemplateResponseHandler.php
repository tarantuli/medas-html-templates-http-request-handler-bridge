<?php

declare(strict_types=1);

namespace Medas\HtmlTemplatesHttpRequestHandlerBridge;

use Medas\HtmlTemplates\TemplateCompiler;
use Medas\HttpRequestHandler\{Request\Request,
    ResponseHandlerManager,
    ResponseHandlers\HtmlHandler,
    ResponseHandlers\ResponseHandler,
    ResponseTypes\Response};
use Medas\ServiceManager\Service;

#[Service]
class HtmlTemplateResponseHandler extends HtmlHandler implements ResponseHandler
{
    public function __construct(
        private readonly TemplateCompiler $templateCompiler,
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

        echo $this->templateCompiler->compile($response);

        return true;
    }
}
