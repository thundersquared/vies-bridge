<?php

namespace App\Http\Controllers;

use App\Services\ViesService;
use DragonBe\Vies\ViesException;
use DragonBe\Vies\ViesServiceException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Laminas\Diactoros\Response\XmlResponse;

class CheckVat extends Controller
{
    protected ViesService $service;

    public function __construct()
    {
        $this->service = new ViesService();
    }

    /**
     * Handle the incoming request.
     *
     * @param Request $request
     * @return Response|JsonResponse|XmlResponse
     * @throws ViesException
     * @throws ViesServiceException
     */
    public function __invoke(Request $request): Response|JsonResponse|XmlResponse
    {
        return response()->preferredFormat($this->service->validateVat($request->input('countryCode'),
            $request->input('vatNumber'),
            $request->input('requesterCountryCode'),
            $request->input('requesterVatNumber')));
    }
}
