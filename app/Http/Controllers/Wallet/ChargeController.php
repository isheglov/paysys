<?php

namespace App\Http\Controllers\Wallet;

use App\Http\Controllers\Controller;
use App\Operation\Wallet\Charge\Service;
use App\Service\ServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Operation\Wallet\Charge\Dto\Request as RequestDto;

final class ChargeController extends Controller
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
     * @param Request $wallet
     * @return JsonResponse
     */
    public function charge(Request $wallet, int $walletId): JsonResponse
    {
        var_dump($walletId);

        if (!$this->validateRequest()) {
            return $this->response('Validation error', Response::HTTP_BAD_REQUEST);
        }

        $response = $this->service->behave(new RequestDto($walletId, $wallet->get('amount')));

        return $this->response($response, Response::HTTP_OK);
    }

    /**
     * @return bool
     */
    private function validateRequest(): bool
    {
        // add validation by standart WalletRequest *required
        return true;
    }

    /**
     * @param $response
     * @param $status
     * @return JsonResponse
     */
    protected function response($response, $status): JsonResponse
    {
        return JsonResponse::create($response, $status, ['Content-Type' => 'application/json']);
    }
}
