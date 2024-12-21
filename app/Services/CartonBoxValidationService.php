<?php

namespace App\Services;

use App\Repositories\CartonBoxValidationRepository;

class CartonBoxValidationService
{
    protected $validationRepository;

    public function __construct(CartonBoxValidationRepository $validationRepository)
    {
        $this->validationRepository = $validationRepository;
    }

    public function validateCartonBox($barcode)
    {
        return $this->validationRepository->validateCartonBox($barcode);
    }
}
