<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview;

use PragmaGoTech\Interview\Model\FeeRange;

final readonly class PercentageCalculation implements CalculationMethod
{
    private const int ROUNDING_FACTOR = 5;

    public function calculate(float $amount, FeeRange $feeRange): float
    {
        $rangeDifference = $feeRange->getMaxAmount() - $feeRange->getMinAmount();

        if (.0 === $rangeDifference) {
            return $feeRange->getMaxFee();
        }

        $amountDifference = $amount - $feeRange->getMinAmount();

        $percentage = $amountDifference * 100 / $rangeDifference;

        $fee = $this->calculateFeeWithoutRounding($feeRange, $percentage);

        return $this->roundFee($fee, $amount);
    }

    private function calculateFeeWithoutRounding(FeeRange $feeRange, float $percentage): float
    {
        return $feeRange->getMinFee() + ($feeRange->getMaxFee() - $feeRange->getMinFee()) * ($percentage / 100);
    }

    private function roundFee(float $fee, float $amount): float
    {
        return (ceil(($fee + $amount) / self::ROUNDING_FACTOR) * self::ROUNDING_FACTOR) - $amount;
    }
}
