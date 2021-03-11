<?php

declare(strict_types=1);

namespace App\Controller;

use Psr\Http\Message\ServerRequestInterface;

/**
 * Class ApiController
 */
class ApiController
{
    public function get(ServerRequestInterface $request): array
    {
        return ['message' => 'get test success'];
    }

    public function post(ServerRequestInterface $request): array
    {
        return ['message' => 'post test success'];
    }

    public function getWithParams(ServerRequestInterface $request): array
    {
        /*
         * receive param1 in the queryString of the get request
         */
        $param = $request->getQueryParams()['param1'];
        return ['message' => 'param received ' . $param];
    }

    public function postWithParams(ServerRequestInterface $request): array
    {
        /*
         * receive param1 in the post request
         */
        $param = $request->getParsedBody()['param1'];
        return ['message' => 'param received ' . $param];
    }
}
