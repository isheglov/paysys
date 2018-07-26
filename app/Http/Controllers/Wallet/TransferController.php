<?php

namespace App\Http\Controllers\Wallet;

use App\Dto\ErroneousResponse;
use App\Http\Controllers\Controller;
use App\Operation\Wallet\Transfer\Dto\Money;
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
     * @param Request $request
     * @param int $walletFromId
     * @param int $walletToId
     * @return JsonResponse
     */
    public function transfer(Request $request, int $walletFromId, int $walletToId): JsonResponse
    {

        if (!$this->validateRequest($request)) {
            return $this->response('Validation error', Response::HTTP_BAD_REQUEST);
        }

        $response = $this->service->behave($this->createRequest($request, $walletFromId, $walletToId));

        if ($response instanceof ErroneousResponse) {
            return $this->response($response->getMessage(), Response::HTTP_OK);
        }

        return $this->response($response, Response::HTTP_OK);
    }

    /**
     * @param $request
     * @return bool
     */
    private function validateRequest($request): bool
    {
        // add validation by standart WalletRequest *required
        return $request->get('amount') > 0;
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

    /**
     * @param Request $request
     * @param int $walletFromId
     * @param int $walletToId
     * @return RequestDto
     */
    protected function createRequest(Request $request, int $walletFromId, int $walletToId): RequestDto
    {
        return new RequestDto($walletFromId, $walletToId, $this->createMoney($request));
    }

    /**
     * @param Request $request
     * @return Money
     */
    protected function createMoney(Request $request): Money
    {
        return new Money($request->get('amount'), $request->get('currency'));
    }
}
