<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview;

use PragmaGoTech\Interview\Model\LoanProposal;
use PragmaGoTech\Interview\Repository\FeeRangeRepository;

/**
 * Explanation:
 *
 * I could have implemented something like 'PercentageFeeCalculator' and put there the calculation logic instead
 * of using the strategy pattern but i think the strategy pattern is more flexible.
 *
 * With the strategy pattern i would consider removing the FeeCalculator interface but of course it depends on the
 * context.
 */
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
