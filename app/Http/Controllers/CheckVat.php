<?php

namespace App\Http\Controllers;

use App\Services\ViesService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Laminas\Diactoros\Response\XmlResponse;

class CheckVat extends Controller
{
    protected ViesService $service;
    const FIELDS = [
        'countryCode',
        'vatNumber',
        'requesterCountryCode',
        'requesterVatNumber',
    ];

    public function __construct()
    {
        $this->service = new ViesService();
    }

    /**
     * Handle the incoming request.
     *
     * @param Request $request
     * @return Response|JsonResponse|XmlResponse
     */
    public function __invoke(Request $request): Response|JsonResponse|XmlResponse
    {
        $fields = [];

        foreach (self::FIELDS as $field)
        {
            // Load into fields array checking both body and query
            $fields[$field] = $request->input($field, $request->query($field));

            // Directly return on missing fields
            if (empty($fields[$field]))
            {
                $message = sprintf('"%s" field is missing', $field);

                // Track missing fields
                Log::error($message, [
                    'request' => $request,
                    'server' => $request->server,
                    'ip' => $request->ip(),
                    'fields' => $fields,
                ]);

                return $this->respond([
                    'statusCode' => 400,
                    'status' => 'invalid',
                    'error' => $message,
                ]);
            }
        }

        try
        {
            // Attempt VAT validation
            return $this->respond([
                'statusCode' => 200,
                ...$this->service->validateVat(...$fields),
            ]);
        } catch (\Exception $e)
        {
            // Track failed checks
            Log::error($e->getMessage(), [
                'request' => $request,
                'server' => $request->server,
                'ip' => $request->ip(),
                'fields' => $fields,
            ]);

            // Fail on any error
            return $this->respond([
                'statusCode' => 406,
                'status' => 'invalid',
                'error' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Simple response method that spits out the data
     * and sets the proper HTTP status code when set
     *
     * @param $response
     * @return Response|JsonResponse|XmlResponse
     */
    protected function respond($response): Response|JsonResponse|XmlResponse
    {
        return response()->preferredFormat($response, $response['statusCode'] ?? 200);
    }
}
