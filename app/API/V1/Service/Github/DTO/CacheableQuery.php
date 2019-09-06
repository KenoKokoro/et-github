<?php

namespace ET\API\V1\Service\Github\DTO;

use Carbon\Carbon;

interface CacheableQuery
{
    /**
     * Get the cache key
     * @return string
     */
    public function getCacheSignature(): string;

    /**
     * @return Carbon
     */
    public function getCacheTtl(): Carbon;
}
