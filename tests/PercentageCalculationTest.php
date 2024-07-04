<?php

declare(strict_types=1);

namespace Tests;

use PHPUnit\Framework\Attributes\DataProvider;
use PragmaGoTech\Interview\Model\FeeLimit;
use PragmaGoTech\Interview\Model\FeeRange;
use PragmaGoTech\Interview\PercentageCalculation;
use PHPUnit\Framework\TestCase;

class PercentageCalculationTest extends TestCase
{
    /**
     * @return array<int, array<string, mixed>>
     */
    public static function calculateFeeProvider(): array
    {
        return [
            [
                'range' => new FeeRange(new FeeLimit(11_000.0, 440.0), new FeeLimit(12_000.0, 480.0)),
                'amount' => 11_500.0,
                'expectedFee' => 460.0,
            ],
            [
                'range' => new FeeRange(new FeeLimit(19_000.0, 380.0), new FeeLimit(20_000.0, 400.0)),
                'amount' => 19_250.0,
                'expectedFee' => 385.0,
            ],
            [
                'range' => new FeeRange(new FeeLimit(2000.0, 100.0), new FeeLimit(3000.0, 120.0)),
                'amount' => 2750,
                'expectedFee' => 115.0,
            ],
            [
                'range' => new FeeRange(new FeeLimit(2000.0, 90.0), new FeeLimit(3000.0, 90.0)),
                'amount' => 2750,
                'expectedFee' => 90,
            ],
            [
                'range' => new FeeRange(new FeeLimit(1000.0, 100.0), new FeeLimit(1000.0, 100.0)),
                'amount' => 1000.0,
                'expectedFee' => 100.0,
            ],
            [
                'range' => new FeeRange(new FeeLimit(20_000.0, 400.0), new FeeLimit(20_000.0, 400.0)),
                'amount' => 20_000,
                'expectedFee' => 400.0,
            ],
            [
                'range' => new FeeRange(new FeeLimit(11_000.0, 440.0), new FeeLimit(12_000.0, 480.0)),
                'amount' => 11_255.43,
                'expectedFee' => 454.5699999999997,
            ],
            [
                'range' => new FeeRange(new FeeLimit(2000.0, 100.0), new FeeLimit(3000.0, 120.0)),
                'amount' => 2001.23,
                'expectedFee' => 103.76999999999998,
            ],
        ];
    }

    #[DataProvider('calculateFeeProvider')]
    public function testCalculateFee(FeeRange $range, float $amount, float $expectedFee): void
    {
        // given
        $method = (new PercentageCalculation());

        // when
        $fee = $method->calculate($amount, $range);

        // then
        self::assertEquals($expectedFee, $fee);
        // and
        self::assertEquals(0, ($amount + $expectedFee) % 5);
    }
}
