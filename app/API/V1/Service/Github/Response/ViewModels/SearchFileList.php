<?php

namespace ET\API\V1\Services\Github\Response\ViewModels;

use JsonSerializable;

class SearchFileList implements JsonSerializable
{
    /**
     * @var array
     */
    private $files;

    public function __construct(array $files)
    {
        $this->files = $files;
    }

    /**
     * @param array $files
     * @return SearchFileList
     * @codeCoverageIgnore
     */
    public static function make(array $files): SearchFileList
    {
        return new self($files);
    }

    public function jsonSerialize(): array
    {
        return $this->files;
    }
}
