<?php
/**
 * Contains the BaseProxy class.
 *
 * @copyright   Copyright (c) 2017 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2017-05-24
 *
 */


namespace Konekt\Concord\Proxies;

use Konekt\Concord\Contracts\Concord;
use LogicException;

abstract class BaseProxy
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
                sprintf('The proxy %s has a non-existent contract class: `%s`',
                    static::class, $this->contract
                )
            );
        }
    }

    /**
     * This is a method where the dark word 'static' has 7 occurrences
     *
     * @return BaseProxy
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
        return call_user_func(static::getInstance()->targetClass() . '::' . $method, ...$parameters);
    }

    /**
     * Try guessing the associated contract class for a concrete proxy class
     *
     * @return string
     */
    abstract protected function guessContract();

    /**
     * Returns the resolved class
     *
     * @return string
     */
    abstract protected function targetClass() : string;

}