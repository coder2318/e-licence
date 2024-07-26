<?php

namespace App\Services;

use App\Repositories\BaseRepository;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

class BaseService
{
    protected ?BaseRepository $repo;

    protected ?array $relation;

    protected ?array $attributes;
    protected ?array $sort_fields;
    protected ?array $filter_fields;

    /**
     * @param array $params
     * @return mixed
     */
    public function get(array $params, $pagination = true): mixed
    {
        $perPage = null;
        if ($pagination) {
            $perPage = $params['per_page'] ?? 20;
        }

        $query = $this->repo->getQuery();
        $query = $this->relation($query, $this->relation);
        $query = $this->filter($query, $this->filter_fields, $params);
        $query = $this->sort($query, $this->sort_fields, $params);
        $query = $this->select($query, $this->attributes);
        return $this->repo->getOrPaginate($query, $perPage);
    }


    /**
     * @param array $params
     * @return mixed
     */
    public function list(array $params): mixed
    {
        $query = $this->repo->getQuery();
        $query = $this->filter($query, $this->filter_fields, $params);
        $query = $this->relation($query, $this->relation);
        $query = $this->select($query, $this->attributes);
        $query = $this->sort($query, $this->sort_fields, $params);
        if(isset($params['limit']))
            $query = $query->limit($params['limit']);

        return $query->get();
    }

    /**
     * @param Builder $query
     * @param null $relation
     * @return Builder
     */
    public function relation(Builder $query, $relation = null): Builder
    {
        if ($relation) {
            $query->with($relation);
        }
        return $query;
    }

    /**
     * @param Builder $query
     * @param null $attributes
     * @return Builder
     */
    public function select(Builder $query, $attributes = null): Builder
    {
        if ($attributes) {
            $query->select($attributes);
        }
        return $query;
    }


    /**
     * @param Builder $query
     * @param $filter_fields
     * @param $params
     * @return Builder
     */
    public function filter(Builder $query, $filter_fields, $params): Builder
    {
        foreach ($filter_fields as $key => $item) {
            if (array_key_exists($key, $params)) {
                if ($item['type'] == 'string' && $params[$key] != '')
                    $query->where($key, 'ilike', '%' . $params[$key] . '%');

                if ($item['type'] == 'array' && $params[$key])
                    $query->whereIn($key, $params[$key]);

                if ($item['type'] == 'intarray' && $params[$key]) {
                    $value = "{" . implode(',', $params[$key]) . "}";
                    $query->where($key, '&&', $value);
                }

                if ($item['type'] == 'intarrayand' && $params[$key]) {
                    $value = "{" . implode(',', $params[$key]) . "}";
                    $query->where($key, '@>', $value);
                }

                if ($item['type'] == 'number' && $params[$key] != '')
                    $query->where($key, $params[$key]);
                if ($item['type'] == 'bool' && $params[$key] != '')
                    $query->where($key, $params[$key]);
                if ($item['type'] == 'day' && $params[$key] != '')
                    $query->where($key, '>=', Carbon::now()->subDays($params[$key]));

                if ($item['type'] == 'to' && $params[$key] != '')
                    $query->where($key, '<=', $params[$key]);

                if ($item['type'] == 'from' && $params[$key] != '')
                    $query->where($key, '>=', $params[$key]);

                if ($params[$key] and $item['type'] == 'json' and $item['json_type'] == 'array') {
                    if ($item['search'] == 'string')
                        $query->where('data->' . $key . '', 'ilike', $params[$key]);
                    if ($item['search'] == 'number')
                        $query->where('data->' . $key . '', $params[$key]);
                }

                if ($item['type'] == 'isNull')
                    $query->whereNull($key);

                if ($item['type'] == 'notNull')
                    $query->whereNotNull($key);

                if ($params[$key] and $item['type'] == 'whereHas' and array_key_exists('relation', $item)) {
                    $query->whereHas($item['relation'], function (Builder $builder) use ($params, $key, $item){
                        if ($item['search'] == 'number')
                            $builder->where($key, $params[$key]);
                        if ($item['search'] == 'string')
                            $builder->where($key, 'ilike', '%'.$params[$key].'%');
                    });
                }
            }
        }
        return $query;
    }

    /**
     * @param $query
     * @param array $sort_fields
     * @param array $params
     * @return Builder
     */
    public function sort($query, array $params, array $sort_fields = []): Builder
    {
        $key = 'id';
        $order = 'desc';
        if (isset($sort_fields) and isset($sort_fields['sort_key'])) {
            $key = $sort_fields['sort_key'];
            $order = $sort_fields['sort_type'];
        }
        if (isset($params) and isset($params['sort_by'])) {
            $key = $params['sort_by'];
            $order = $params['order_by']??'desc';
        }
        $query->orderBy($key, $order);

        return $query;
    }

    /**
     * @param $params
     * @return object|null
     */
    public function create($params): object|null
    {
        return $this->repo->store($params);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function show($id): mixed
    {
        return $this->repo->getById($id);
    }

    /**
     * @param $params
     * @param $id
     * @return mixed
     */
    public function edit($params, $id): mixed
    {
        return $this->repo->update($params, $id);
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function delete(int $id): mixed
    {
        return $this->repo->destroy($id);
    }

    /**
     * @param array $rows
     * @return mixed
     */
    public function insert(array $rows): mixed
    {
        return $this->repo->insert($rows);
    }
}
