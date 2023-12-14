<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Boq\Departments\Eme\BoqEmeLoadCalculation;
use App\Boq\Departments\Eme\BoqEmeLoadCalculationDetails;

class CheckParentChildCombinedUniqueArray implements Rule
{
    private string $attribute;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(
        private mixed $searchedClass,
        private mixed $relationTable,
        private array $ConditionWhere,
        private string $column,
        private mixed $columnValue,
        private string $customMessage = ''
    )
    {}

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $this->attribute = $attribute;
        $tableData = $this->searchedClass::whereHas($this->relationTable,function($q){
            $q->where($this->ConditionWhere);
        })->where($this->column, $this->columnValue)
        ->whereIn($attribute, $value)
        ->get();

        return !count($tableData);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return strlen($this->customMessage) ? $this->customMessage : "Some Material is already been inserted for this project for respective floor.";
    }
}
