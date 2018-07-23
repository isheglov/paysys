<?php

namespace App\Http\Controllers\Wallet;

use App\Dto\ErroneousResponse;
use App\Http\Controllers\Controller;
use App\Operation\Wallet\Transfer\Service;
use App\Service\ServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Operation\Wallet\Transfer\Dto\Request as RequestDto;

final class TransferController extends Controller
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
     * @param int $walletFromId
     * @param int $walletToId
     * @return JsonResponse
     */
    public function transfer(Request $wallet, int $walletFromId, int $walletToId): JsonResponse
    {

        if (!$this->validateRequest()) {
            return $this->response('Validation error', Response::HTTP_BAD_REQUEST);
        }

        $response = $this->service->behave(new RequestDto($walletFromId, $walletToId, $wallet->get('amount')));

        if ($response instanceof ErroneousResponse) {
            return $this->response($response->getMessage(), Response::HTTP_OK);
        }

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
