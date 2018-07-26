<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Operation\Wallet\History\GetList\Dto\Criteria;
use App\Operation\Wallet\History\GetList\Service;
use App\Repositories\HistoryRepositoryInterface;
use App\Service\ServiceInterface;
use DB;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

final class ReportController extends Controller
{
    /**
     * @var ServiceInterface
     */
    private $service;

    /**
     * @var HistoryRepositoryInterface
     */
    private $historyRepository;

    /**
     * @param ServiceInterface|Service $service
     * @param HistoryRepositoryInterface $historyRepository
     */
    public function __construct(ServiceInterface $service, HistoryRepositoryInterface $historyRepository)
    {
        $this->service = $service;
        $this->historyRepository = $historyRepository;
    }

    /**
     * @param Request $request
     * @return View
     */
    public function show(Request $request)
    {
        $historyListPaginationAware = [];
        $sum = 0;
        $sumUsd = 0;
        $countPages = 0;
        if ($request->input('userId') !== null) {
            $historyListPaginationAware = $this->service->behave($request);

            $sum = $this->historyRepository->sumByCriteria($this->createCriteria($request));
            $sumUsd = $this->historyRepository->sumUsdByCriteria($this->createCriteria($request));

            $countPages = $this->getTotalPagesCount($historyListPaginationAware);
        }

        return
            view(
                'report',
                [
                    'userList' => User::all(),
                    'pageList' => $this->getPagesList($countPages),
                    'userIdSelected' => $request->input('userId'),
                    'pageSelected' => $request->input('page'),
                    'dateFrom' => $request->input('dateFrom'),
                    'dateTo' => $request->input('dateTo'),
                    'operationList' => $this->getOperationList($historyListPaginationAware),
                    'sumInWalletCurrency' => (float) $sum / 100,
                    'sumInUSD' => (float) $sumUsd / 100,
                    'walletCurr' => 'eur',
                ]
            );
    }

    /**
     * @param $historyListPaginationAware
     * @return mixed
     */
    private function getOperationList($historyListPaginationAware)
    {
        if (empty($historyListPaginationAware)) {
            return [];
        }

        return $historyListPaginationAware->items();
    }

    /**
     * @param Request $request
     * @return Criteria
     */
    private function createCriteria(Request $request): Criteria
    {
        return
            new Criteria(
                $request->input('userId'),
                $request->input('dateFrom'),
                $request->input('dateTo')
            );
    }

    /**
     * @param $historyListPaginationAware
     * @return int
     */
    private function getTotalPagesCount($historyListPaginationAware): int
    {
        return (int)($historyListPaginationAware->total() / $historyListPaginationAware->perPage())
            + ($historyListPaginationAware->total() % $historyListPaginationAware->perPage() ? 1 : 0);
    }

    /**
     * @param $countPages
     * @return array
     */
    private function getPagesList($countPages): array
    {
        if (!$countPages) {
            return [];
        }

        return range(1, $countPages);
    }
}
