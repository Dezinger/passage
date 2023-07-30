<?php

namespace Morcen\Passage\Services;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PassageService implements PassageServiceInterface
{
    protected string $method;

    protected array $headers = [];

    protected array $params = [];

    public function prepareService(Request $request, PendingRequest $service): void
    {
        $method = strtolower($request->method());
        $this->setMethod($method);

        $options = $service->getOptions();

        if ($headers = $options['headers']) {
            $this->setHeaders($headers);
        }
    }

    public function callService(Request $request, PendingRequest $service, string $uri): JsonResponse
    {
        // TODO: prepare headers
        $method = strtolower($request->method());
        $params = $request->all();

        /** @var Response $response */
        $response = $service->{$method}($uri, $params);

        return response()->json($response->object(), $response->status());
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function setMethod(string $method): void
    {
        $this->method = $method;
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function setHeaders(array $headers): void
    {
        $this->headers = $headers;
    }

    public function getParams(): array
    {
        return $this->params;
    }

    public function setParams(array $params): void
    {
        $this->params = $params;
    }
}
