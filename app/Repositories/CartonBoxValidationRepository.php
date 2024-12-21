<?php

namespace App\Repositories;

use App\Models\CartonBox;
use App\Models\PackingList;
use App\Models\Rule;
use Illuminate\Support\Facades\DB;

class CartonBoxValidationRepository extends BaseRepository
{
    protected $cartonBoxModel;
    protected $packingListModel;
    protected $ruleModel;

    public function __construct(CartonBox $cartonBox, PackingList $packingList, Rule $rule)
    {
        $this->cartonBoxModel = $cartonBox;
        $this->packingListModel = $packingList;
        $this->ruleModel = $rule;
    }

    /**
     * Validate a carton box by barcode.
     *
     * @param string $barcode
     * @return array
     * @throws \Exception
     */
    public function validateCartonBox($barcode)
    {
        // Find the carton box by barcode
        $cartonBox = $this->cartonBoxModel->where('barcode', $barcode)->first();

        if (!$cartonBox) {
            throw new \Exception("Carton box not found.");
        }

        // Check if carton box has already been validated
        if ($cartonBox->status === 'verified') {
            return [
                'status' => 'already_verified',
                'message' => 'This carton box has already been verified.',
            ];
        }

        // Find the associated packing list
        $packingList = $this->packingListModel->find($cartonBox->packing_list_id);

        if (!$packingList) {
            throw new \Exception("Packing list not found for the carton box.");
        }

        // Get the validation rules from the packing list
        $rules = $this->ruleModel->where('packing_list_id', $packingList->id)->get();

        // Perform rule-based validation
        foreach ($rules as $rule) {
            $validationResult = $this->applyRule($cartonBox, $rule);
            if (!$validationResult['is_valid']) {
                return [
                    'status' => 'failed',
                    'message' => $validationResult['message'],
                ];
            }
        }

        // Update the carton box status to 'verified'
        $cartonBox->update(['status' => 'verified']);

        return [
            'status' => 'success',
            'message' => 'Carton box has been successfully verified.',
        ];
    }

    /**
     * Apply a specific rule to a carton box.
     *
     * @param CartonBox $cartonBox
     * @param Rule $rule
     * @return array
     */
    protected function applyRule(CartonBox $cartonBox, Rule $rule)
    {
        switch ($rule->type) {
            case 'SOLID':
                return $this->validateSolidRule($cartonBox, $rule);

            case 'RATIO':
                return $this->validateRatioRule($cartonBox, $rule);

            default:
                return [
                    'is_valid' => false,
                    'message' => "Unknown rule type: {$rule->type}",
                ];
        }
    }

    /**
     * Validate a carton box with the SOLID rule.
     *
     * @param CartonBox $cartonBox
     * @param Rule $rule
     * @return array
     */
    protected function validateSolidRule(CartonBox $cartonBox, Rule $rule)
    {
        $items = $cartonBox->items; // Assume carton box has items relationship

        foreach ($items as $item) {
            if (
                $item->size !== $rule->size ||
                $item->color !== $rule->color
            ) {
                return [
                    'is_valid' => false,
                    'message' => "SOLID rule failed: Item {$item->id} does not match the required attributes.",
                ];
            }
        }

        return [
            'is_valid' => true,
            'message' => 'SOLID rule passed.',
        ];
    }

    /**
     * Validate a carton box with the RATIO rule.
     *
     * @param CartonBox $cartonBox
     * @param Rule $rule
     * @return array
     */
    protected function validateRatioRule(CartonBox $cartonBox, Rule $rule)
    {
        $items = $cartonBox->items; // Assume carton box has items relationship
        $ratios = $rule->ratios; // Assume rule has ratios relationship

        $counts = [];
        foreach ($items as $item) {
            $key = "{$item->size}_{$item->color}";
            $counts[$key] = ($counts[$key] ?? 0) + 1;
        }

        foreach ($ratios as $ratio) {
            $key = "{$ratio->size}_{$ratio->color}";
            if (($counts[$key] ?? 0) !== $ratio->quantity) {
                return [
                    'is_valid' => false,
                    'message' => "RATIO rule failed: Expected {$ratio->quantity} of {$ratio->size}, {$ratio->color} but found " . ($counts[$key] ?? 0),
                ];
            }
        }

        return [
            'is_valid' => true,
            'message' => 'RATIO rule passed.',
        ];
    }
}
