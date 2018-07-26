@extends('app')

@section('content')
    <div class="container">
        <div class="col-sm-offset-2 col-sm-8">
            <div class="panel panel-default">
                <div class="panel-body">
                    <form>
                        <div>
                            <select name="userId">
                                @foreach ($userList as $user)
                                    @if ($userIdSelected == $user->id)
                                        <option value="{{ $user->id }}" selected>{{ $user->name }}</option>
                                        @continue
                                    @endIf
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>

                            From: <input type="date" name="dateFrom" value="{{ $dateFrom }}"/>
                            To: <input type="date" name="dateTo" value="{{ $dateTo }}"/>

                            <input value="Show report" type="submit"/>

                        </div>
                        <table class="table table-striped task-table">
                            <tbody>
                                <tr style="background-color: #f5f5f5; font-weight: bold;">
                                    <td>Amount</td>
                                    <td>Date</td>
                                </tr>
                                @foreach ($operationList as $operation)
                                    <tr>
                                        <td class="table-text"><div>{{ $operation->amount }}</div></td>
                                        <td class="table-text"><div>{{ $operation->date }}</div></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        @foreach ($pageList as $page)
                            @if ($pageSelected == $page)
                                <button name="page" value="{{$page}}" >{{$page}}</button>
                                @continue
                            @endIf
                            <button name="page" value="{{$page}}">{{$page}}</button>
                        @endforeach
                    </form>

                    <p>sumInWalletCurrency: {{ $sumInWalletCurrency }}</p>
                    <p>sumInUSD: {{ $sumInUSD }}</p>
                    <button>Download report</button>
                </div>
            </div>
        </div>
    </div>
@endsection
