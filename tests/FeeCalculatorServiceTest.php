<?php

declare(strict_types=1);

namespace Tests;

use PragmaGoTech\Interview\FeeCalculatorService;
use PHPUnit\Framework\TestCase;
use PragmaGoTech\Interview\Model\LoanProposal;
use PragmaGoTech\Interview\PercentageCalculation;
use PragmaGoTech\Interview\Repository\InMemoryFeeRangeRepository;

class FeeCalculatorServiceTest extends TestCase
{
    public function testThrowsExceptionIfThereIsNoFeeRange(): void
    {
        // given
        $service = new FeeCalculatorService(
            new PercentageCalculation(),
            new InMemoryFeeRangeRepository([]),
        );

        // then
        $this->expectExceptionMessage('Cannot find Fee Range for term "12" and amount "1500.00".');

        // when
        $service->calculate(new LoanProposal(12, 1500.0));
    }

    public function testCalculateFee(): void
    {
        // given
        $service = new FeeCalculatorService(
            new PercentageCalculation(),
            new InMemoryFeeRangeRepository(),
        );

        // when
        $fee = $service->calculate(new LoanProposal(12, 2500));

        // then
        $this->assertEquals(90.0, $fee);
    }
}
