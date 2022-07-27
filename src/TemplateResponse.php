<?php

declare(strict_types=1);

namespace Medas\HtmlTemplatesHttpRequestHandlerBridge;

use Medas\HtmlTemplates\Templates\HtmlTemplate;
use Medas\HttpRequestHandler\ResponseTypes\Response;

class TemplateResponse implements Response
{
    public function __construct(
        public HtmlTemplate $template
    )
    {
    }
}
