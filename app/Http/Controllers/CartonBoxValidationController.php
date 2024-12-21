<?php

namespace App\Http\Controllers;

use App\Services\CartonBoxValidationService;
use Illuminate\Http\Request;

class CartonBoxValidationController extends Controller
{
    protected $validationService;

    public function __construct(CartonBoxValidationService $validationService)
    {
        $this->validationService = $validationService;
    }

    public function validate(Request $request)
    {
        $request->validate([
            'barcode' => 'required|string',
        ]);

        try {
            $result = $this->validationService->validateCartonBox($request->barcode);

            return response()->json([
                'status' => $result['status'],
                'message' => $result['message'],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 400);
        }
    }
}
