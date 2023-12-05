<?php

namespace App\Rules;

use App\Construction\MaterialPlan;
use Illuminate\Contracts\Validation\Rule;

class MaterialPlanRule implements Rule
{
    private $project_id;
    private $from_date;
    private $to_date;
    private $id;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(int $project_id, string $from_date, string $to_date, int $id = null)
    {
        $this->project_id = $project_id;
        $this->from_date = $from_date;
        $this->to_date = $to_date;
        $this->id = $id;
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
        $year = $this->formatYear($this->from_date);
        $month = $this->formatMonth($this->to_date);

        $material_plan = MaterialPlan::where('year', $year)
            ->where('id','!=',$this->id)
            ->where('month', $month)
            ->where('project_id', $this->project_id)
            ->first();

        return empty($material_plan);
    }

    /**
     *  Formats the date into year.
     *
     * @return string
     */
    private function formatYear(string $date): string
    {
        return substr(date_format(date_create($date), "Y"), 0);
    }

    /**
     *  Formats the date into month.
     *
     * @return string
     */
    private function formatMonth(string $date): string
    {
        return substr(date_format(date_create($date), "m"), 0);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'A plan can not be submitted twice for a particular month of a year.';
    }
}
