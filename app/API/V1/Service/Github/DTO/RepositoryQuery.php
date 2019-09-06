<?php

namespace ET\API\V1\Service\Github\DTO;

class RepositoryQuery extends AbstractQuery
{
    /**
     * @var string
     */
    private $owner;

    /**
     * @var string
     */
    private $repository;

    public function __construct(string $owner, string $repository)
    {
        $this->owner = $owner;
        $this->repository = $repository;
    }

    public function getQueryString(): string
    {
        return "repo:{$this->owner}/{$this->repository}";
    }
}
