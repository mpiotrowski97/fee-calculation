<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\Model;

final readonly class FeeLimit
{
    public function __construct(public float $amount, public float $fee)
    {
    }
}
