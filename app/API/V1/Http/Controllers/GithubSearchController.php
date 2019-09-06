<?php

namespace ET\API\V1\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Response\ResponseFactoryInterface;
use ET\API\V1\Services\Github\GithubService;
use ET\API\V1\Validation\WordsCountRule;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GithubSearchController extends Controller
{
    /**
     * @var GithubService
     */
    private $githubService;

    public function __construct(GithubService $githubService)
    {
        $this->githubService = $githubService;
    }

    /**
     * @param Request                  $request
     * @param ResponseFactoryInterface $responseFactory
     * @return JsonResponse
     * @throws Exception
     */
    public function keyword(Request $request, ResponseFactoryInterface $responseFactory): JsonResponse
    {
        $validated = $this->validate($request, [
            'owner' => ['required'],
            'repository' => ['required'],
            'keyword' => ['required', new WordsCountRule],
        ]);

        $dto = $this->githubService->dtoFactory()->makeKeywordQueryFromAttributes(
            $validated['keyword'],
            $validated['owner'],
            $validated['repository']
        );
        $response = $this->githubService->searchFiles($dto);

        return $responseFactory->json()->ok(['result' => $response]);
    }
}
