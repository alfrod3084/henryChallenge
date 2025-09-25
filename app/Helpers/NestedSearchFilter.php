<?php

namespace App\Helpers;

use App\Models\Appointment;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;

class NestedSearchFilter
{
    /**
     * Return the correct sql query build with the filters required.
     *
     * @param Builder $query
     * @param array $filters
     * @return Builder
     */
    public static function applyFilters(Builder $query, array $filters): Builder
    {
        foreach ($filters as $field => $value) {
            if (str_contains($field, '.')) {
                $val = explode('.', $field, 2);
                $relation = $val[0];
                $column = $val[1];
                if ($query->from != $relation) {
                    $query->whereHas($relation, function (Builder $q) use ($column, $value) {
                        if (is_array($value) && Arr::has($value, 'or')) {
                            $q->orWhere($column, $value['or']);
                        } else {
                            $q->where($column, $value);
                        }
                    });
                } else {
                    $query->where($column, $value);
                }
            }
        }
        return $query;
    }

    public static function execute()
    {
        $filters = [
            "appointment.status" => "confirmed",
            "patient.name" => "John",
            "location.city" => "Dallas"
        ];
        $query = self::applyFilters(Appointment::query(),$filters);
        $sql = $query->toSql();
        $bindings = $query->getBindings();
        if ($query->count() > 0) {
            $items = [];
            foreach ($query->get() as $value) {
                $items['appointment'] = [
                    'id_appointment' => $value->id_appointment,
                    'title' => $value->title,
                    'patient' => [
                        'id' => $value->id_patient
                    ],
                    'location' => [
                        'id' => $value->id_location
                    ]
                ];
            }
        }
        if (!empty($items)) {
            echo json_encode($items);
        } else {
            echo "No records found with the current filters";
        }
    }
}
