<?php

namespace App\Http\Helpers;

use Illuminate\Support\Str;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;

class MethodsHelpers
{
    public static function post($endpoint, $data = [])
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Client-ID cb8c5d9613f3073',
            ])->post($endpoint, $data);
            $res = json_decode($response->getBody(), true);
            return $res;
        } catch (RequestException $e) {
            return response()->json(['error' => 'Terjadi masalah dengan permintaan HTTP'], 500);
        }
    }
    public static function order($query, $order)
    {
        if ($order === '-id') {
            $query->orderBy('id', "desc");
        }

        return $query;
    }

    public static function entities($query, $entities)
    {
        if ($entities != null || $entities != '') {
            $entities = str_replace(' ', '', $entities);
            $entities = explode(',', $entities);

            try {
                return $query = $query->with($entities);
            } catch (\Throwable $th) {
                return Json::exception(null, validator()->errors());
            }
        }
    }

    public static function limit($query, $limit)
    {
        if ($limit) {
            $query->limit($limit);
        }

        return $query;
    }

    public static function search($query, $q, $records = 'name')
    {
        if ($q) {
            $query->where($records, $q);
        }

        return $query;
    }

    public static function trashData($query, $is_trash)
    {
        if ($is_trash) {
            $query->onlyTrashed();
        }

        return $query;
    }

    public static function generatedSlug($q, $title)
    {
        $new_slug = Str::slug($title);
        $slug_check = $q->where('slug', $new_slug)->count();
        if ($slug_check == 0) {
            $slug = $new_slug;
        } else {
            $check = 0;
            $unique = false;
            while ($unique == false) {
                $inc_id = ++$check;
                $check = $q->where('slug', $new_slug . '-' . $inc_id)->count();
                if ($check > 0) {
                    $unique = false;
                } else {
                    $unique = true;
                }
            }
            $slug = $new_slug . '-' . $inc_id;
        }

        return $slug;
    }

    public static function whereWithEntities($query, $entities, $field, $target)
    {
        if ($entities && $field && $target) {
            $query->whereHas($entities, function ($queryBuilder) use ($field, $target) {
                if ($field && $target) {
                    $queryBuilder->where($target, $field);
                }

                return $queryBuilder;
            });
        }
        return $query;
    }

    public static function whereInArray($query, $record, $values)
    {
        if ($query && $values && $record) {
            $query->whereIn($record, $values);
        }

        return $query;
    }

    public static function whereWithSummary($query, $target, $summary)
    {
        if ($summary && $target) {
            $query->where($target, $summary);
        }
    }

    public static function getterUserId($request)
    {
        return $request ? $request->user()->id : null;
    }

    public static function filterByDateRange($query, $targetField, $since, $until)
    {
        if ($query && $since && $until) {
            $query->whereBetween($targetField, [$since, $until]);
        }

        return $query;
    }

    public static function filterByField($query, $record, $target)
    {
        if ($query && $record && $target) {
            $query->where($record, $target);
        }

        return $query;
    }


    // DRY -> dont repeat yourself // 
}
