<?php

namespace App\Http\Controllers;

use App\Models\CartonBox;
use App\Repositories\CartonBoxRepository;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CartonBoxController extends Controller
{
    protected $cartonBoxRepo;

    public function __construct(CartonBoxRepository $cartonBoxRepo)
    {
        $this->cartonBoxRepo = $cartonBoxRepo;
    }

    // Search for a carton box by barcode
    public function search(Request $request)
    {
        $barcode = $request->input('barcode');

        $cartonBox = $this->cartonBoxRepo->findByBarcode($barcode);

        if ($cartonBox) {
            return Inertia::render('CartonBox/Search', [
                'cartonBox' => $cartonBox,
            ]);
        }

        return Inertia::render('CartonBox/Search', [
            'errors' => ['error' => 'Carton Box not found.'],
        ]);
    }


    // Validate the carton box
    public function validate(Request $request, CartonBox $cartonBox)
    {
        $packingList = $cartonBox->packingList;

        if (!$cartonBox->is_verified) {
            $isValid = $this->cartonBoxRepo->validateCarton($cartonBox, $packingList);

            if ($isValid) {
                $cartonBox->update(['is_verified' => true]);
                return Inertia::render('CartonBox/Verified', [
                    'cartonBox' => $cartonBox,
                    'message' => 'Carton Box successfully validated.',
                ]);
            } else {
                return redirect()->route('carton-boxes.search')
                    ->withErrors(['error' => 'Carton Box validation failed!']);
            }
        }

        return Inertia::render('CartonBox/Verified', [
            'cartonBox' => $cartonBox,
            'message' => 'This Carton Box is already validated.',
        ]);
    }
}
