<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Operation\User\Create\Service;
use App\Service\ServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

final class CreateController extends Controller
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
     * @param Request $user
     * @return JsonResponse
     */
    public function create(Request $user): JsonResponse
    {
        var_dump($user->get('name'));

        if (!$this->validateRequest()) {
            return $this->response('Validation error', Response::HTTP_BAD_REQUEST);
        }

        $response = $this->service->behave($user);

        return $this->response($response, Response::HTTP_OK);
    }

    /**
     * @return bool
     */
    private function validateRequest(): bool
    {
        // add validation by standart UserRequest *required
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
