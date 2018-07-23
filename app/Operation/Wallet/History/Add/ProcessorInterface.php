<?php

namespace App\Operation\Wallet\History\Add;

interface ProcessorInterface
{
    /**
     * @param $historyDto
     * @return void
     */
    public function process($historyDto);
}
