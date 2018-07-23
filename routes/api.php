<?php

# User
Route::post('user', 'User\CreateController@create');

# Wallet
Route::put('wallet/{walletId}/charge', 'Wallet\ChargeController@charge');

Route::post('wallet/{walletFromId}/sendTo/{walletToId}', 'Wallet\TransferController@transfer');

# Rate
Route::post('rate', 'Rate\AddController@add');