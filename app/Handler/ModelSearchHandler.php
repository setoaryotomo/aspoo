<?php

namespace App\Handler;

class ModelSearchHandler
{
    public static function handle($query, $searchable, $keyword)
    {
        return $query->where(function ($query) use ($searchable, $keyword) {
            if ($keyword != null && $keyword != "") {
                foreach ($searchable as $field) {
                    if (str_contains($field, '.')) {
                        $relation = explode('.', $field)[0];
                        $relation_field = explode('.', $field)[1];
                        $query->orWhereHas($relation, function ($query) use ($keyword, $relation_field) {
                            $query->where($relation_field, 'LIKE', '%' . $keyword . '%');
                        });
                    } else {
                        $query->orWhere($field, 'LIKE', '%' . $keyword . '%');
                    }
                }
            }
        });
    }
}
