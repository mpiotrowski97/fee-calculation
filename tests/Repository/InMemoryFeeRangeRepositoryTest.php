<?php

declare(strict_types=1);

namespace Tests\Repository;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use PragmaGoTech\Interview\Model\FeeLimit;
use PragmaGoTech\Interview\Model\FeeRange;
use PragmaGoTech\Interview\Model\LoanProposal;
use PragmaGoTech\Interview\Repository\InMemoryFeeRangeRepository;
use Ramsey\Collection\Collection;

class InMemoryFeeRangeRepositoryTest extends TestCase
{
    /**
     * @return array<int, array<string, mixed>>
     */
    public static function findRangeProvider(): array
    {
        return [
            [
                'loanProposal' => new LoanProposal(12, 3500.0),
                'expectedMin' => 3000.0,
                'expectedMax' => 4000.0
            ],
            [
                'loanProposal' => new LoanProposal(12, 1240.322),
                'expectedMin' => 1000.0,
                'expectedMax' => 2000.0
            ],
            [
                'loanProposal' => new LoanProposal(12, 1000.0),
                'expectedMin' => 1000.0,
                'expectedMax' => 1000.0
            ],
            [
                'loanProposal' => new LoanProposal(12, 20_000.0),
                'expectedMin' => 20_000.0,
                'expectedMax' => 20_000.0,
            ],
        ];
    }

    public function testReturnsNullIfCannotFindBoundaries(): void
    {
        // given
        $repository = new InMemoryFeeRangeRepository([12 => new Collection(FeeLimit::class, [
            new FeeLimit(20_000.0, 400.0),
        ])]);

        // when
        $feeRange = $repository->findFeeRangeForLoanProposal(new LoanProposal(12, 1500));

        // then
        $this->assertNull($feeRange);
    }

    public function testReturnNullIfTermDoesNotExist(): void
    {
        // given
        $repository = new InMemoryFeeRangeRepository([50 => new Collection(FeeLimit::class, [])]);

        // when
        $feeRange = $repository->findFeeRangeForLoanProposal(new LoanProposal(12, 1500));

        // then
        $this->assertNull($feeRange);
    }

    #[DataProvider('findRangeProvider')]
    public function testFindRange(LoanProposal $loanProposal, float $expectedMin, float $expectedMax): void
    {
        // given
        $repository = new InMemoryFeeRangeRepository();

        // when
        $range = $repository->findFeeRangeForLoanProposal($loanProposal);

        // then
        self::assertInstanceOf(FeeRange::class, $range);
        // and
        self::assertEquals($expectedMin, $range->getMinAmount());
        // and
        self::assertEquals($expectedMax, $range->getMaxAmount());
    }
}
