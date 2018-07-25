<?php

namespace App\Operation\Rate\Add;

use App\Models\Rate;
use App\Repositories\RateRepositoryInterface;
use App\Service\ServiceInterface;
use Psr\Log\LoggerAwareTrait;
use Psr\Log\LoggerInterface;

final class Service implements ServiceInterface
{
    use LoggerAwareTrait;

    /**
     * @var RateRepositoryInterface
     */
    private $rateRepository;

    /**
     * @param RateRepositoryInterface $rateRepository
     * @param LoggerInterface $logger
     */
    public function __construct(RateRepositoryInterface $rateRepository, LoggerInterface $logger)
    {
        $this->setLogger($logger);

        $this->rateRepository = $rateRepository;
    }

    /**
     * @param mixed $request
     * @return mixed
     */
    public function behave($request)
    {
        $rateList = $request->get('rates', []);

        foreach ($rateList as $curr => $rate) {
            $rateModel = $this->createRate($curr, $rate);

            $this->rateRepository->save($rateModel);
        }

        return ['ok'];
    }

    /**
     * @param $curr
     * @param $rate
     * @return Rate
     */
    private function createRate($curr, $rate): Rate
    {
        $rateModel = new Rate();

        $rateModel->curr = $curr;
        $rateModel->rate = $rate;
        $rateModel->date = date('Y-m-d');

        return $rateModel;
    }
}
