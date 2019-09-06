<?php

namespace ET\API\V1\DAL;

use ET\API\V1\DAL\Github\GithubApi;
use ET\API\V1\DAL\Github\GithubRepository;
use Illuminate\Support\ServiceProvider;

class DalServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $toBind = [
            GithubRepository::class => GithubApi::class,
        ];

        $this->bind($toBind);
    }

    /**
     * @param array $instanceMap
     */
    private function bind(array $instanceMap): void
    {
        foreach ($instanceMap as $interface => $instance) {
            $this->app->bind($interface, $instance);
        }
    }
}
