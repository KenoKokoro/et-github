<?php

namespace ET\API\V1\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Response\ResponseFactoryInterface;
use Exception;
use Illuminate\Http\JsonResponse;

class SearchController extends Controller
{
    /**
     * @param ResponseFactoryInterface $responseFactory
     * @return JsonResponse
     * @throws Exception
     */
    public function search(ResponseFactoryInterface $responseFactory)
    {
        return $responseFactory->json()->ok();
    }
}
