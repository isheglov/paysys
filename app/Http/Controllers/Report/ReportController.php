<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Operation\Wallet\History\GetList\Dto\History;
use Illuminate\Http\Request;

final class ReportController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Request $request)
    {
        var_dump($request->input('userName'));
        var_dump($request->input('dateFrom'));
        var_dump($request->input('dateTo'));
        var_dump($request->input('page'));


        //call get list service


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
