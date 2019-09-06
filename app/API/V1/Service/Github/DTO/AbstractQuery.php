<?php

namespace ET\API\V1\Service\Github\DTO;

abstract class AbstractQuery
{
    abstract public function getQueryString(): string;
}
