<?php

namespace ET\API\V1\Tests\Acceptance\Mocks;

use App\API\V1\DAL\Github\GithubResponseCollection;
use ET\API\V1\DAL\Github\GithubRepository;
use ET\API\V1\Services\Github\DTO\KeywordQuery;
use Illuminate\Support\ServiceProvider;

class MockServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(GithubRepository::class, function() {
            return new class implements GithubRepository
            {
                public function searchCode(KeywordQuery $query): GithubResponseCollection
                {
                    return new GithubResponseCollection(2, [['path' => 'file1'], ['path' => 'file2']], false);
                }
            };
        });
    }
}
