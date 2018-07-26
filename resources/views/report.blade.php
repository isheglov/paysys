@extends('app')

@section('content')
    <div class="container">
        <div class="col-sm-offset-2 col-sm-8">
            <div class="panel panel-default">
                <div class="panel-body">
                    <form>
                        <div>
                            <select name="userId">
                                <option value="1">Петя</option>
                                <option value="2">Коля</option>
                                <option value="3">Вася</option>
                            </select>

                            From: <input type="date" name="dateFrom"/>
                            To: <input type="date" name="dateTo"/>

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
                                        <td class="table-text"><div>{{ $operation->getAmount() }}</div></td>
                                        <td class="table-text"><div>{{ $operation->getDate() }}</div></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <button name="page" value="1">1</button>
                        <button name="page" value="2">2</button>
                        <button>3</button>
                        <button>4</button>
                        <button>5</button>
                        <button>6</button>
                        <button>7</button>
                        <button>8</button>
                        <button>9</button>
                        <button>10</button>
                        <button>11</button>
                        <button>12</button>
                        <button>13</button>
                        <button>14</button>
                        <button>15</button>
                        <button>16</button>
                        <button>17</button>
                        <button>18</button>
                        <button>19</button>
                        <button>20</button>
                        <button>21</button>
                        <button>22</button>
                        <button>23</button>
                        <button>24</button>
                        <button>25</button>
                        <button>26</button>
                        <button>27</button>
                        <button>28</button>
                    </form>

                    <p>sumInWalletCurrency: {{ $sumInWalletCurrency }}</p>
                    <p>sumInUSD: {{ $sumInUSD }}</p>
                    <button>Download report</button>
                </div>
            </div>
        </div>
    </div>
@endsection
