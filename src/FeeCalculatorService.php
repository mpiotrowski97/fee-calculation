<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview;

use PragmaGoTech\Interview\Model\LoanProposal;
use PragmaGoTech\Interview\Repository\FeeRangeRepository;

final readonly class FeeCalculatorService implements FeeCalculator
{
    public function __construct(
        private CalculationMethod $calculationMethod,
        private FeeRangeRepository $feeRangeRepository,
    ) {
    }

    public function calculate(LoanProposal $application): float
    {
        $feeRange = $this->feeRangeRepository->findFeeRangeForLoanProposal($application);

        if (null === $feeRange) {
            throw new \RuntimeException(
                sprintf(
                    'Cannot find Fee Range for term "%d" and amount "%.2f".',
                    $application->term,
                    $application->amount
                )
            );
        }

        return $this->calculationMethod->calculate($application->amount, $feeRange);
    }
}
