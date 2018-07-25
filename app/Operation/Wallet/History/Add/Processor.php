<?php

namespace App\Operation\Wallet\History\Add;

use App\Models\History;
use App\Operation\Common\CurrencyConverter\CurrencyConverterInterface;
use App\Operation\Wallet\History\Add\Dto\History as HistoryDto;
use App\Repositories\HistoryRepositoryInterface;

final class Processor implements ProcessorInterface
{
    /**
     * @var HistoryRepositoryInterface
     */
    private $historyRepository;

    /**
     * @var CurrencyConverterInterface
     */
    private $converter;

    /**
     * @param HistoryRepositoryInterface $historyRepository
     * @param CurrencyConverterInterface $converter
     */
    public function __construct(HistoryRepositoryInterface $historyRepository, CurrencyConverterInterface $converter)
    {
        $this->historyRepository = $historyRepository;
        $this->converter = $converter;
    }

    /**
     * {@inheritdoc}
     */
    public function process(HistoryDto $historyDto)
    {
        $history = new History();

        $history->wallet_id = $historyDto->getWallet()->id;
        $history->amount = $historyDto->getAmount();
        $history->amount_usd = $this->getAmountUsd($historyDto);
        $history->date = date('Y-m-d');

        $this->historyRepository->save($history);
    }

    /**
     * @param HistoryDto $historyDto
     * @return int
     */
    private function getAmountUsd(HistoryDto $historyDto): int
    {
        return
            $this
                ->converter
                ->convertToUsd(
                    $historyDto->getAmount(),
                    $historyDto->getWallet()->currency
                );
    }
}
