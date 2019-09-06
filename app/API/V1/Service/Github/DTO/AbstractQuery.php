<?php

namespace ET\API\V1\Services\Github\DTO;

abstract class AbstractQuery
{
    abstract public function getQueryString(): string;
}
