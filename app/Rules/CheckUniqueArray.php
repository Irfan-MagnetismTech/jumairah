<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class CheckUniqueArray implements Rule
{
    private string $attribute;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(
        private string $table,
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

        $tableData = DB::table($this->table)
            ->where($this->column, $this->columnValue)
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
        return strlen($this->customMessage) ? $this->customMessage : "The {$this->attribute} is already inserted.";
    }
}
