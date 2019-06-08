<?php
/**
 * Contains the ModelProxy class.
 *
 * @copyright   Copyright (c) 2017 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2017-04-08
 *
 */

namespace Konekt\Concord\Proxies;

/**
 * @method static \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection|null find($id, $columns = ['*'])
 * @method static \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection findOrFail($id, $columns = ['*'])
 * @method static \Illuminate\Database\Eloquent\Collection findMany($ids, $columns = ['*'])
 * @method static \Illuminate\Database\Eloquent\Model findOrNew($id, $columns = ['*'])
 * @method static \Illuminate\Database\Eloquent\Model|object|null first($columns = ['*'])
 * @method static \Illuminate\Support\Collection get($columns = ['*'])
 * @method static int delete($id = null)
 * @method static bool insert(array $values)
 * @method static int insertGetId(array $values, $sequence = null)
 * @method static int update(array $values)
 * @method static bool updateOrInsert(array $attributes, array $values = [])
 * @method static \Illuminate\Database\Query\Builder where($column, $operator = null, $value = null, $boolean = 'and')
 * @method static \Illuminate\Database\Query\Builder whereIn($column, $values, $boolean = 'and', $not = false)
 * @method static \Illuminate\Database\Query\Builder whereNotIn($column, $values, $boolean = 'and')
 * @method static \Illuminate\Database\Query\Builder whereBetween($column, array $values, $boolean = 'and', $not = false)
 * @method static \Illuminate\Database\Query\Builder whereExists(\Closure $callback, $boolean = 'and', $not = false)
 * @method static \Illuminate\Database\Query\Builder whereNotExists(\Closure $callback, $boolean = 'and')
 * @method static \Illuminate\Database\Query\Builder whereNull($column, $boolean = 'and', $not = false)
 * @method static \Illuminate\Database\Query\Builder whereNotNull($column, $boolean = 'and')
 * @method static \Illuminate\Database\Query\Builder latest($column = 'created_at')
 * @method static \Illuminate\Database\Query\Builder oldest($column = 'created_at')
 * @method static \Illuminate\Database\Query\Builder limit($value)
 * @method static \Illuminate\Database\Query\Builder take($value)
 * @method static \Illuminate\Database\Query\Builder tap($callback)
 * @method static \Illuminate\Database\Query\Builder|mixed when($value, $callback, $default = null)
 * @method static bool each(callable $callback, $count = 1000)
 * @method static mixed value($column)
 * @method static mixed min($column)
 * @method static mixed max($column)
 * @method static mixed sum($column)
 * @method static mixed avg($column)
 * @method static \Illuminate\Database\Query\Builder orderBy($column, $direction = 'asc')
 * @method static \Illuminate\Database\Query\Builder orderByDesc($column)
 * @method static \Illuminate\Support\Collection pluck($column, $key = null)
 */
abstract class ModelProxy extends BaseProxy
{
    /**
     * Returns the real model class FQCN
     *
     * @return string
     */
    public static function modelClass()
    {
        $instance = static::getInstance();

        return $instance->targetClass();
    }

    /**
     * @inheritDoc
     */
    protected function targetClass(): string
    {
        return $this->concord->model($this->contract);
    }

    /**
     * Try guessing the associated contract class for actual proxy
     * Depends on the concord convention the default pattern is
     * 'UserProxy' -> entity = 'User' -> '../Contracts/User'
     *
     * @return string
     */
    protected function guessContract()
    {
        return $this->concord->getConvention()->contractForModel(
            $this->concord->getConvention()->modelForProxy(static::class)
        );
    }
}
