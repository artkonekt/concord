<?php
/**
 * Contains the Repository class.
 *
 * @copyright   Copyright (c) 2017 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2017-04-08
 *
 */


namespace Konekt\Concord\Database;


use Konekt\Concord\Contracts\Concord;
use LogicException;

abstract class ModelProxy
{
    /** @var string */
    protected $contract;

    /** @var array */
    protected static $instances = [];

    /** @var Concord */
    protected $concord;

    /**
     * Repository constructor.
     *
     * @param Concord $concord
     */
    public function __construct(Concord $concord = null)
    {
        $this->concord = $concord ?: app(Concord::class);

        if (empty($this->contract)) {
            $this->contract = $this->guessContract();
        }

        if (!interface_exists($this->contract)) {
            throw new LogicException(
                sprintf('The repository %s has a non-existent contract class: `%s`',
                    static::class, $this->contract
                )
            );
        }
    }

    /**
     * This is a method where the dark word 'static' has 7 occurrences
     *
     * @return ModelProxy
     */
    public static function getInstance()
    {
        if (!isset(static::$instances[static::class])) {
            static::$instances[static::class] = new static();
        }

        return static::$instances[static::class];
    }

    /**
     * @param $method
     * @param $parameters
     *
     * @return mixed
     */
    public static function __callStatic($method, $parameters)
    {
        return call_user_func(static::getInstance()->modelClass() . '::' . $method, ...$parameters);
    }

    /**
     * Returns the real model class FQCN
     *
     * @return string
     */
    public static function modelClass()
    {
        $instance = static::getInstance();

        return $instance->concord->model($instance->contract);
    }

    /**
     * Try guessing the associated contract class for actual repository
     * Depends on the convention used by concord, default pattern is
     * 'UserRepository' => entity = 'User' => '../Contracts/User'
     *
     * @return string
     */
    private function guessContract()
    {
        return $this->concord->getConvention()->contractForModel(
            $this->concord->getConvention()->modelForProxy(static::class)
        );
    }

}

