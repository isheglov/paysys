<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Operation\Wallet\History\GetList\Dto\History;
use App\Operation\Wallet\History\GetList\Service;
use App\Service\ServiceInterface;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

final class ReportController extends Controller
{
    /**
     * @var ServiceInterface
     */
    private $service;

    /**
     * @param ServiceInterface|Service $service
     */
    public function __construct(ServiceInterface $service)
    {
        $this->service = $service;
    }

    /**
     * @param Request $request
     * @return View
     */
    public function show(Request $request)
    {
        $historyListPaginationAware = [];
        if ($request->input('userId') !== null) {
            $historyListPaginationAware = $this->service->behave($request);
        }

        var_dump($historyListPaginationAware->items());

        var_dump($historyListPaginationAware->currentPage());
        var_dump($historyListPaginationAware->total());


        return
            view(
                'report',
                [
                    'userList' => [],
                    'pageList' => [],
                    'userSelected' => new User(),
                    'pageSelected' => 1,
                    'dateFrom' => '2018-09-09',
                    'dateTo' => '2018-09-09',
                    'operationList' => $this->getDtoList(),
                    'sumInWalletCurrency' => 12768376.8217,
                    'sumInUSD' => 12312312.8217,
                ]
            );
    }

    /**
     * @return array
     */
    private function getDtoList(): array
    {
        return
            [
                $this->createDto(),
                $this->createDto(),
                $this->createDto(),
                $this->createDto(),
                $this->createDto(),

                $this->createDto(),
                $this->createDto(),
                $this->createDto(),
                $this->createDto(),
                $this->createDto(),
            ];
    }

    /**
     * @return History
     */
    private function createDto(): History
    {
        return new History(123, '2018-03-03');
    }
}
