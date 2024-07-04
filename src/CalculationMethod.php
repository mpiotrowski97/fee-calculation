<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview;

use PragmaGoTech\Interview\Model\FeeRange;

interface CalculationMethod
{
    public function calculate(float $amount, FeeRange $feeRange): float;
}
