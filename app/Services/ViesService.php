<?php

namespace App\Services;

use DragonBe\Vies\Vies;
use DragonBe\Vies\ViesException;
use DragonBe\Vies\ViesServiceException;

class ViesService
{
    protected Vies $client;

    public function __construct()
    {
        $this->client = new Vies();
    }

    /**
     * @throws ViesServiceException
     * @throws ViesException
     */
    public function validateVat(
        string $countryCode,
        string $vatNumber,
        string $requesterCountryCode = '',
        string $requesterVatNumber = ''): array
    {
        // Attempt VAT validation
        $check = $this->client->validateVat(
            $countryCode,
            $vatNumber,
            $requesterCountryCode,
            $requesterVatNumber
        );

        return [
            'status' => $check->isValid() ? 'valid' : 'invalid',
            'result' => $check->toArray(),
        ];
    }
}
