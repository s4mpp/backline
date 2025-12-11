<?php

namespace S4mpp\AdminPanel\Utils;

use S4mpp\AdminPanel\Labels\Label;
use S4mpp\Backline\Support\Ordenation;
use Illuminate\Database\Eloquent\Builder;
use S4mpp\AdminPanel\Utils\Label as UtilsLabel;

abstract class Query
{
    // /**
    //  * @param  array<Label>  $columns
    //  * @return array<string>
    //  */
    // public static function getSelectFields(array $columns, string $table = null): array
    // {
    //     if (empty($columns)) {
    //         return [join('.', array_filter([$table, '*']))];
    //     }

    //     $select_fields = [join('.', array_filter([$table, 'id']))];

    //     foreach ($columns as $column) {
    //         $field = $column->getField();

    //         if (is_null($field)) {
    //             continue;
    //         }

    //         if (UtilsLabel::isRelationShip($field)) {
    //             continue;
    //         }

    //         $select_fields[] = $field;
    //     }

    //     return array_unique($select_fields);
    // }

    // public static function getSelectFieldsToSum(array $columns)
    // {
    //     foreach ($columns as $column) {
    //         $field_name = $column->getField();

    //         if (is_null($field_name)) {
    //             continue;
    //         }

    //         if (UtilsLabel::isRelationShip($field_name)) {
    //             continue;
    //         }

    //         if (! method_exists($column, 'sum') || ! $column->hasSum()) {
    //             continue;
    //         }

    //         $field_for_sum = $column->getFieldForSum();

    //         if(!$field_for_sum) {
    //             $field_for_sum = $field_name;
    //         }

    //         $select_fields_to_sum[] = 'SUM('.$field_for_sum.') as '.$field_name;
    //     }

    //     return $select_fields_to_sum ?? [];
    // }

    public static function getSortFields(Ordenation $default_sort)
    {
        return [$default_sort->getField().' '.$default_sort->getDirection()];
    }

    // public static function getSortFields(Ordenation $default_sort, array $columns, array $sort_config)
    // {
    //     if (! $sort_config) {
    //         return [$default_sort->getField().' '.$default_sort->getDirection()];
    //     }

    //     $sort_fields = [];

    //     array_walk($columns, function (Label $label) use ($sort_config, &$sort_fields): void {
    //         $sort = $label->getCurrentSort($sort_config);

    //         if ($sort) {
    //             $sort_fields[] = 'TRIM('.$label->getField().') '.$sort;
    //         }
    //     });

    //     return $sort_fields;
    // }

    // public static function getEagerLoadingFields($main_model, array &$select_fields, array $columns)
    // {
    //     foreach ($columns as $column) {
    //         $field = $column->getField();

    //         if (is_null($field)) {
    //             continue;
    //         }

    //         if (! UtilsLabel::isRelationShip($field)) {
    //             continue;
    //         }

    //         $model = $main_model;

    //         $path = explode('.', $field);

    //         $field = array_pop($path);

    //         $parent = null;

    //         $current_index = $parent_index = null;

    //         foreach ($path as $path) {
    //             $relationship = $model->{$path}();

    //             $relation_name = $relationship->getRelationName();

    //             if (! $parent) {
    //                 $select_fields[] = $relationship->getForeignKeyName();

    //                 $current_index = $relation_name;
    //             } elseif ($parent_index) {
    //                 $eager_loadings[$parent_index][] = $relationship->getForeignKeyName();

    //                 $current_index .= '.'.$relation_name;
    //             }

    //             $model = $relationship->getRelated();

    //             $parent = $relation_name;

    //             $parent_index = $current_index;
    //         }

    //         $eager_loadings[$current_index][] = $field;
    //     }

    //     foreach ($eager_loadings ?? [] as $relationship => $fields) {
    //         $eager_loading_fields[] = $relationship.':id,'.implode(',', array_unique($fields));
    //     }

    //     return $eager_loading_fields ?? [];
    // }

    // public static function search(string $field_name, array $search_by)
    // {
    //     return function ($builder) use ($field_name, $search_by): void {

    //         $search_term = request()->get($field_name);

    //         if (is_null($search_term) || empty($search_term)) {
    //             return;
    //         }

    //         $search_terms = explode(',', $search_term);

    //         $search_terms = array_map(fn($value) => trim($value), $search_terms);

    //         foreach ($search_by as $text_searcher) {

    //             $key = $text_searcher->getField();

    //             if (UtilsLabel::isRelationShip($key)) {
    //                 // TODO group relationships

    //                 $path = explode('.', $key);

    //                 $field = array_pop($path);

    //                 $relationship = implode('.', $path);

    //                 foreach ($search_terms as $search_term) {

    //                     //TODO duplicado
    //                     $search_term = $text_searcher->prepareSearchTerm($search_term);

    //                     if($text_searcher->isExact()) {
    //                         $q = fn ($builder) => $builder->where($field, $search_term);
    //                     }else {
    //                         $q = fn ($builder) => $builder->where($field, 'like', '%'.$search_term.'%');
    //                     }

    //                     $builder->orWhereRelation($relationship, $q);

    //                 }

    //                 continue;
    //             }

    //             foreach ($search_terms as $search_term) {

    //                 //TODO duplicado
    //                 $search_term = $text_searcher->prepareSearchTerm($search_term);

    //                 if($text_searcher->isExact()) {
    //                     $builder->orWhere($key, $search_term);
    //                 }else {
    //                     $builder->orWhere($key, 'like', '%'.$search_term.'%');
    //                 }
    //             }
    //         }
    //     };
    // }

    // public static function filter(array $filters, array $selected_filters = [])
    // {
    //     return function (Builder $builder) use ($filters, $selected_filters): void {

    //         foreach ($filters as $filter) {

    //             $field_name = $filter->getFieldName();

    //             $term = $selected_filters[$field_name] ?? null;

    //             if ($filter->isEmpty($term)) {
    //                 continue;
    //             }

    //             $callback = $filter->getCallback();

    //             if($callback === false) {
    //                 continue;
    //             }

    //             if(is_callable($callback)) {
    //                 $builder->where($callback($builder, $term, $selected_filters));
    //             } else {
    //                 $builder->where($filter->query($term));
    //             }
    //         }
    //     };
    // }
}
