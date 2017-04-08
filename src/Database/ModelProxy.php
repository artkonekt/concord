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


namespace Database;


use LogicException;

abstract class ModelProxy
{
    protected $contract;

    /** @var UserProxy */
    protected static $instance;

    protected $app;

    public function __construct($app = null)
    {
        if (empty($this->contract)) {
            $this->contract = $this->guessContract();
        }

        if (!class_exists($this->contract)) {
            throw new LogicException(
                sprintf('The proxy %s has a non-existent contract class: `%s`',
                    static::class, $this->contract
                )
            );
        }

        $this->app = $app ?: app();
    }

    public static function getInstance()
    {
        if (is_null(static::$instance)) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    public static function __callStatic($method, $parameters)
    {
        return call_user_func(static::getInstance()->realClass() . '::' . $method, ...$parameters);
    }

    public function useModelClass($extendedClass)
    {
        $this->app->alias($extendedClass, $this->contract);
    }

    public function realClass()
    {
        return $this->app->getAlias($this->contract);
    }

    /**
     * Returns the associated entity's name eg 'OrderProxy' => 'Order'
     *
     * @return string
     */
    public function entityName()
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

