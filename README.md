# medas-html-templates-http-request-handler-bridge

Part of the [Medas framework](https://github.com/tarantuli/medas-core).

## Description

A thin bridge between `medas-html-templates` and `medas-http-request-handler`. It provides two classes:

**`TemplateResponse`** extends `HtmlTemplate` and implements the `Response` marker interface, making an HTML template directly returnable as an HTTP response from a request handler.

**`HtmlTemplateResponseHandler`** is a `ResponseHandler` registered at priority −4 (higher than the default `HtmlHandler` at −20). When the current response is a `TemplateResponse` and the request accepts `text/html`, it compiles the template via `TemplateCompiler` and echoes the result.

Without this bridge, returning an `HtmlTemplate` from a request handler would require manually compiling it and wrapping the output in a plain `HtmlResponse`. With the bridge in place, request handlers can return a `TemplateResponse` directly and the response dispatcher takes care of the rest.

## Usage

### Package developer context

Register the package — it pulls in both `HtmlTemplatesPackage` and `HttpRequestHandlerPackage` as dependencies:

```php
use Medas\HtmlTemplatesHttpRequestHandlerBridge\HtmlTemplatesHttpRequestHandlerBridgePackage;

HtmlTemplatesHttpRequestHandlerBridgePackage::instance();
```

**Returning a `TemplateResponse` from a request handler:**

```php
use Medas\HtmlTemplatesHttpRequestHandlerBridge\TemplateResponse;
use Medas\HttpRequestHandler\RequestHandlers\RequestHandler;
use Medas\HttpRequestHandler\ResponseTypes\Response;
use Medas\Core\Attributes\Service;

#[Service]
readonly class DashboardHandler implements RequestHandler
{
    public function handle(): Response
    {
        return new TemplateResponse(
            template: '<html><body><h1>Dashboard</h1></body></html>',
        );
    }
}
```

**Using template variables:**

```php
return new TemplateResponse(
    template: '<html><body><p>Hello, <m:var name="username" />!</p></body></html>',
    variables: ['username' => $currentUser->name],
);
```

**Using a parent layout template:**

```php
// The child template's content is injected into the parent's <children> placeholder
return new TemplateResponse(
    template: '<main><p>Page content here.</p></main>',
    parent: new HtmlTemplate(
        template: file_get_contents('templates/layout.html'),
    ),
);
```

**Sharing a default parent layout** — configure `html-templates.default-parent-template` (from `medas-html-templates`) so every `TemplateResponse` is automatically wrapped in the layout without explicitly passing `parent`:

```php
// In your bootstrap, after registering the package:
// The TemplateCompiler applies the configured default parent to any template
// that has no explicit parent set.
return new TemplateResponse(
    template: '<main><p>Page content here.</p></main>',
    // parent is set automatically from the default-parent-template config option
);
```

### Backend user context

Once the bridge package is registered, replacing `HtmlResponse` with `TemplateResponse` in any handler is all that is needed:

```php
// Before (manual compile):
use Medas\HtmlTemplates\TemplateCompiler;
use Medas\HtmlTemplates\Templates\HtmlTemplate;
use Medas\HttpRequestHandler\ResponseTypes\HtmlResponse;

return new HtmlResponse($templateCompiler->compile(new HtmlTemplate($templateString)));

// After (via bridge):
use Medas\HtmlTemplatesHttpRequestHandlerBridge\TemplateResponse;

return new TemplateResponse(template: $templateString);
```

The `HtmlTemplateResponseHandler` only activates for requests that include `text/html` in their `Accept` header. For API requests that accept only `application/json`, the handler returns `false` and the dispatcher falls through to the next registered handler.
