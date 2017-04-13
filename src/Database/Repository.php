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


use Illuminate\Contracts\Foundation\Application;
use LogicException;

abstract class Repository
{
    /** @var string */
    protected $contract;

    /** @var array */
    protected static $instances = [];

    /** @var Application */
    protected $app;

    /**
     * Repository constructor.
     *
     * @param Application $app
     */
    public function __construct($app = null)
    {
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

        $this->app = $app ?: app();
    }

    /**
     * This is a method where the dark word 'static' has 7 occurrences
     *
     * @return Repository
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
     * Set the repository to use the given model class
     *
     * @param string $extendedClass
     */
    public static function useModelClass($extendedClass)
    {
        $instance = static::getInstance();
        $instance->app->alias($extendedClass, $instance->contract);
    }

    /**
     * Returns the real model class FQCN
     *
     * @return string
     */
    public static function modelClass()
    {
        $instance = static::getInstance();

        return $instance->app->getAlias($instance->contract);
    }

    /**
     * Returns the associated entity's name eg 'OrderRepository' => 'Order'
     *
     * @return string
     */
    public static function entityName()
    {
        return str_replace_last('Repository', '', class_basename(static::class));
    }

    /**
     * Try guessing the associated contract class for the actual repository
     * Pattern is 'UserRepository' => entity name is 'User' => contract is '../Contracts/User'
     *
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

