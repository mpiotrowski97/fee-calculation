<?php

declare(strict_types=1);

namespace Tests\Model;

use PragmaGoTech\Interview\Model\LoanProposal;
use PHPUnit\Framework\TestCase;

class LoanProposalTest extends TestCase
{
    public function testCannotCreateLoanProposalWithInvalidTerm(): void
    {
        // then
        $this->expectExceptionMessage('Invalid term "50". Term should be 12 or 24 months.');

        // when
        new LoanProposal(50, 5000);
    }

    public function testCannotCreateLoanProposalWithInvalidValue(): void
    {
        // then
        $this->expectExceptionMessage('Invalid amount "50000.00". Amount should be between 1000.00 and 20000.00.');

        // when
        new LoanProposal(12, 50000.00);
    }
}
