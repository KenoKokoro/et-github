<?php

namespace ET\API\V1\Tests\Unit\Validation;

use ET\API\V1\Tests\Unit\UnitTestCase;
use ET\API\V1\Validation\WordsCountRule;
use Illuminate\Contracts\Validation\Rule;

class WordsCountRuleTest extends UnitTestCase
{
    /** @test */
    public function should_create_validation_rule_instance(): void
    {
        $fixture = new WordsCountRule;
        self::assertInstanceOf(WordsCountRule::class, $fixture);
        self::assertInstanceOf(Rule::class, $fixture);
    }

    /** @test */
    public function should_return_the_failed_validation_message(): void
    {
        $fixture = new WordsCountRule;
        self::assertEquals('Only one keyword is allowed', $fixture->message());
    }

    /** @test */
    public function should_fail_when_word_count_passes_the_limit(): void
    {
        $word = "One Two Three";
        $fixture = new WordsCountRule(2);

        self::assertFalse($fixture->passes('', $word));
    }

    /** @test */
    public function should_pass_when_word_count_does_not_passes_the_limit(): void
    {
        $word = "One Two";
        $fixture = new WordsCountRule(2);

        self::assertTrue($fixture->passes('', $word));
    }
}
