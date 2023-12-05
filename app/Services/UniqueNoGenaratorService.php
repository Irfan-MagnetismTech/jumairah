<?php

namespace App\Services;

use App\Project;

class UniqueNoGenaratorService
{


    /**
     * @param model $model
     * @param string $prefix
     * @param columnName $column
     * @param columnValue $columnValue
     * @return string - unique id
     * 
     * this function is used to generate unique id for any model
     */
    public function generateUniqueNo($model, $prefix, $column, $columnValue, $fieldName)
    {
        $lastIndentId = $model::where($column, $columnValue)->whereYear('created_at', now()->format('Y'))->where('is_saved',1)->get();
        $projectName = Project::find($columnValue)->shortName;
        if (count($lastIndentId)) {
            if (!is_null($lastIndentId->last())) {
                $counter = explode('/', $lastIndentId->last()->$fieldName)[3] + 1;
            } else {
                $counter = 1;
            }

            return strtoupper($prefix) . '/' .  $projectName . '/' . now()->format('Y') . '/' . $counter;
        } else {
            return strtoupper($prefix) . '/' .  $projectName . '/' . now()->format('Y') . '/' . 1;
        }
    }
}
