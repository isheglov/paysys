<?php

namespace App\Operation\Wallet\History\Add;

use App\Models\History;
use App\Operation\Wallet\History\Add\Dto\History as HistoryDto;
use App\Repositories\HistoryRepositoryInterface;

final class Processor implements ProcessorInterface
{
    /**
     * @var HistoryRepositoryInterface
     */
    private $historyRepository;

    /**
     * @param HistoryRepositoryInterface $historyRepository
     */
    public function __construct(HistoryRepositoryInterface $historyRepository)
    {
        $this->historyRepository = $historyRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function process(HistoryDto $historyDto)
    {
        $history = new History();

        $history->wallet_id = $historyDto->getWallet()->id;
        $history->amount = $historyDto->getAmount();
        $history->amount_usd = $historyDto->getAmountUsd();
        $history->date = date('Y-m-d');

        $this->historyRepository->save($history);
    }
}
