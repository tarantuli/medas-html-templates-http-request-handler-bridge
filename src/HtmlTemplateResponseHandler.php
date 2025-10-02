<?php

declare(strict_types=1);

namespace Medas\HtmlTemplatesHttpRequestHandlerBridge;

use Medas\Core\Attributes\Service;
use Medas\HtmlTemplates\TemplateCompiler;
use Medas\HttpRequestHandler\{
    ResponseHandlerManager\Job,
    ResponseHandlers\HtmlHandler,
    ResponseHandlers\ResponseHandler
};

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

    public function handleResponse(Job $job): bool
    {
        if (!$job->response instanceof TemplateResponse) {
            return false;
        }

        if (!$this->isHtmlRequest($job->request)) {
            return false;
        }

        echo $this->templateCompiler->compile($job->response);

        return true;
    }
}
