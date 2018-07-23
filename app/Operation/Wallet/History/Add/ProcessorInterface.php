<?php

namespace App\Operation\Wallet\History\Add;

use App\Operation\Wallet\History\Add\Dto\History;

interface ProcessorInterface
{
    /**
     * @param History $historyDto
     * @return void
     */
    public function process(History $historyDto);
}
