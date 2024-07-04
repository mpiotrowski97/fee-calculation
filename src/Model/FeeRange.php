<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\Model;

final readonly class FeeRange
{
    public function __construct(private FeeLimit $min, private FeeLimit $max)
    {
    }

    public function getMinAmount(): float
    {
        return $this->min->amount;
    }

    public function getMaxAmount(): float
    {
        return $this->max->amount;
    }

    public function getMinFee(): float
    {
        return $this->min->fee;
    }

    public function getMaxFee(): float
    {
        return $this->max->fee;
    }
}
