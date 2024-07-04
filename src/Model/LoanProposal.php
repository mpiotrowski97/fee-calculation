<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\Model;

/**
 * A cut down version of a loan application containing
 * only the required properties for this test.
 */
final readonly class LoanProposal
{
    public const int TERM_12 = 12;
    public const int TERM_24 = 24;

    private const array ALLOWED_TERMS = [self::TERM_12, self::TERM_24];

    private const float MIN_AMOUNT = 1000.0;
    private const float MAX_AMOUNT = 20000.0;

    public function __construct(public int $term, public float $amount)
    {
        if (!in_array($this->term, self::ALLOWED_TERMS)) {
            throw new \InvalidArgumentException(
                sprintf(
                    'Invalid term "%d". Term should be %s months.',
                    $this->term,
                    implode(' or ', self::ALLOWED_TERMS)
                )
            );
        }

        if ($this->amount < self::MIN_AMOUNT || $this->amount > self::MAX_AMOUNT) {
            throw new \InvalidArgumentException(
                sprintf(
                    'Invalid amount "%.2f". Amount should be between %.2f and %.2f.',
                    $this->amount,
                    self::MIN_AMOUNT,
                    self::MAX_AMOUNT
                )
            );
        }
    }
}
