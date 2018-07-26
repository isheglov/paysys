<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Models\History;
use App\Models\User;
use App\Operation\Wallet\History\GetList\Dto\Criteria;
use App\Operation\Wallet\History\GetList\Dto\History as HistoryDto;
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
     * @return mixed
     */
    public function export(Request $request)
    {
        $historyList = $this->historyRepository->findByCriteria($this->createCriteria($request));

        $report = "Amount;Date\n";

        /** @var History $history */
        foreach ($historyList as $history) {
            $report .= $this->formatAmount($history->amount) . ';' . $history->date . "\n";
        }

        return
            response()
                ->streamDownload(
                    function () use ($report) {
                        echo $report;
                    },
                    'report.csv'
                );
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
                    'sumInWalletCurrency' => $this->formatAmount($sum),
                    'sumInUSD' => $this->formatAmount($sumUsd),
                    'walletCurr' => $this->getWalletCurrency($request),
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

        $historyList = [];

        foreach ($historyListPaginationAware->items() as $historyModel) {
            $historyList[] = new HistoryDto($this->formatAmount($historyModel->amount), $historyModel->date);
        }

        return $historyList;
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

    /**
     * @param $sum
     * @return float|int
     */
    private function formatAmount($sum)
    {
        return (float)$sum / 100;
    }

    /**
     * @param Request $request
     * @return string
     */
    private function getWalletCurrency(Request $request)
    {
        if ($request->input('userId') === null) {
            return '';
        }

        $curr = User::query()
            ->select('currency')
            ->leftJoin('wallets', 'users.wallet_id', '=', 'wallets.id')
            ->where('users.id', '=', $request->input('userId'))
            ->first();

        return strtoupper($curr->currency);
    }
}
