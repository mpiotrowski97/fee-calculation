<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\Repository;

use PragmaGoTech\Interview\Model\FeeRange;
use PragmaGoTech\Interview\Model\LoanProposal;

interface FeeRangeRepository
{
    public function findFeeRangeForLoanProposal(LoanProposal $loanProposal): ?FeeRange;
}
