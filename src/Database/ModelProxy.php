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


namespace Konekt\Concord\Database;


use LogicException;

abstract class ModelProxy
{
    protected $contract;

    /** @var array */
    protected static $instances = [];

    protected $app;

    public function __construct($app = null)
    {
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

        $this->app = $app ?: app();
    }

    /**
     * This is a method where the dark word 'static' has 7 occurences
     *
     * @return mixed
     */
    public static function getInstance()
    {
        if (!isset(static::$instances[static::class])) {
            static::$instances[static::class] = new static();
        }

        return static::$instances[static::class];
    }

    public static function __callStatic($method, $parameters)
    {
        return call_user_func(static::getInstance()->realClass() . '::' . $method, ...$parameters);
    }

    public static function useModelClass($extendedClass)
    {
        $instance = static::getInstance();
        $instance->app->alias($extendedClass, $instance->contract);
    }

    public static function realClass()
    {
        $instance = static::getInstance();

        return $instance->app->getAlias($instance->contract);
    }

    /**
     * Returns the associated entity's name eg 'OrderProxy' => 'Order'
     *
     * @return string
     */
    public static function entityName()
    {
        return str_replace_last('Proxy', '', class_basename(static::class));
    }

    /**
     * Try guessing the associated contract class to a model proxy
     * Pattern is 'UserProxy' => entity name is 'User' => contract is '../Contracts/User'
     * @return string
     */
    private function guessContract()
    {
        $ns = $this->getNamespace();

        if (empty($ns)) {
            return '';
        }

        return sprintf('%s\\Contracts\\%s', $this->oneLevelUp($ns), $this->entityName());
    }

    /**
     * Returns the namespace of the concrete class
     *
     * @return string
     */
    private function getNamespace()
    {
        return $this->oneLevelUp(static::class);
    }

    /**
     * Chops the last part of the namespace eg \a\b\c => \a\b
     *
     * @param string $namespace
     *
     * @return bool|string
     */
    private function oneLevelUp(string $namespace)
    {
        if ($pos = strrpos($namespace, '\\')) {
            return substr($namespace, 0, $pos);
        }

        return '';
    }

}

