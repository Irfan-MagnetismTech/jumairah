<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Boq\Departments\Eme\BoqEmeLoadCalculation;

class UniqueProjecttypeCalculationtype implements Rule
{
    protected $projectType;
    protected $calculationType; 
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($projectType, $calculationType)
    {
        $this->projectType = $projectType;
        $this->calculationType = $calculationType;
    }


    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        // check if a record already exists with the given project_id, project_type, and calculation_type
        return !BoqEmeLoadCalculation::where([
            'project_id' => $value,
            'project_type' => $this->projectType,
            'calculation_type' => $this->calculationType,
        ])->exists();
    }
    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'A record with this project ID, project type, and calculation type already exists.';
    }
}
