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
