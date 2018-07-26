<?php

namespace App\Http\Controllers\Wallet;

use App\Dto\ErroneousResponse;
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
     * @param int $walletId
     * @return JsonResponse
     */
    public function charge(Request $wallet, int $walletId): JsonResponse
    {
        if (!$this->validateRequest($wallet)) {
            return $this->response('Validation error', Response::HTTP_BAD_REQUEST);
        }

        $response = $this->service->behave(new RequestDto($walletId, $wallet->get('amount')));

        if ($response instanceof ErroneousResponse) {
            return $this->response($response->getMessage(), Response::HTTP_OK);
        }

        return $this->response($response, Response::HTTP_OK);
    }

    /**
     * @param $wallet
     * @return bool
     */
    private function validateRequest($wallet): bool
    {
        // add validation by standart WalletRequest *required
        return $wallet->get('amount') > 0;
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
