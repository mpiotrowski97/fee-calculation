<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\Repository;

use PragmaGoTech\Interview\Model\FeeLimit;
use PragmaGoTech\Interview\Model\FeeRange;
use PragmaGoTech\Interview\Model\LoanProposal;
use Ramsey\Collection\Collection;
use Ramsey\Collection\Exception\NoSuchElementException;

final readonly class InMemoryFeeRangeRepository implements FeeRangeRepository
{
    /**
     * @var array<int, Collection<FeeLimit>>
     */
    private array $ranges;

    /**
     * @param array<int, Collection<FeeLimit>>|null $ranges
     */
    public function __construct(array $ranges = null)
    {
        $this->ranges = $ranges ?? [
            LoanProposal::TERM_12 => new Collection(FeeLimit::class, [
                new FeeLimit(1000.0, 50.0),
                new FeeLimit(2000.0, 90.0),
                new FeeLimit(3000.0, 90.0),
                new FeeLimit(4000.0, 115.0),
                new FeeLimit(5000.0, 100.0),
                new FeeLimit(6000.0, 120.0),
                new FeeLimit(7000.0, 140.0),
                new FeeLimit(8000.0, 160.0),
                new FeeLimit(9000.0, 180.0),
                new FeeLimit(10_000.0, 200.0),
                new FeeLimit(11_000.0, 220.0),
                new FeeLimit(12_000.0, 240.0),
                new FeeLimit(13_000.0, 260.0),
                new FeeLimit(14_000.0, 280.0),
                new FeeLimit(15_000.0, 300.0),
                new FeeLimit(16_000.0, 320.0),
                new FeeLimit(17_000.0, 340.0),
                new FeeLimit(18_000.0, 360.0),
                new FeeLimit(19_000.0, 380.0),
                new FeeLimit(20_000.0, 400.0),
            ]),
            LoanProposal::TERM_24 => new Collection(FeeLimit::class, [
                new FeeLimit(1000.0, 70.0),
                new FeeLimit(2000.0, 100.0),
                new FeeLimit(3000.0, 120.0),
                new FeeLimit(4000.0, 160.0),
                new FeeLimit(5000.0, 200.0),
                new FeeLimit(6000.0, 240.0),
                new FeeLimit(7000.0, 280.0),
                new FeeLimit(8000.0, 320.0),
                new FeeLimit(9000.0, 360.0),
                new FeeLimit(10_000.0, 400.0),
                new FeeLimit(11_000.0, 440.0),
                new FeeLimit(12_000.0, 480.0),
                new FeeLimit(13_000.0, 520.0),
                new FeeLimit(14_000.0, 560.0),
                new FeeLimit(15_000.0, 600.0),
                new FeeLimit(16_000.0, 640.0),
                new FeeLimit(17_000.0, 680.0),
                new FeeLimit(18_000.0, 720.0),
                new FeeLimit(19_000.0, 760.0),
                new FeeLimit(20_000.0, 800.0),
            ]),
        ];
    }

    public function findFeeRangeForLoanProposal(LoanProposal $loanProposal): ?FeeRange
    {
        if (! array_key_exists($loanProposal->term, $this->ranges)) {
            return null;
        }

        $feeRanges = $this->ranges[$loanProposal->term];

        try {
            $min = $feeRanges
                ->filter(static fn (FeeLimit $fee) => $fee->amount <= $loanProposal->amount)
                ->last();

            $max = $feeRanges
                ->filter(static fn (FeeLimit $fee) => $fee->amount >= $loanProposal->amount)
                ->first();
        } catch (NoSuchElementException) {
            return null;
        }

        return new FeeRange($min, $max);
    }
}
