<?php

namespace ET\API\V1\Validation;

use Illuminate\Contracts\Validation\Rule;

class WordsCountRule implements Rule
{
    /**
     * @var int
     */
    private $limit;

    public function __construct(int $limit = 1)
    {
        $this->limit = $limit;
    }

    public function passes($attribute, $value): bool
    {
        $words = explode(" ", $value);

        return count($words) <= $this->limit;
    }

    public function message(): string
    {
        return "Only one keyword is allowed.";
    }
}
