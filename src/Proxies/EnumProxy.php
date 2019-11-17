<?php
/**
 * Contains the EnumProxy class.
 *
 * @copyright   Copyright (c) 2017 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2017-05-24
 *
 */

namespace Konekt\Concord\Proxies;

class EnumProxy extends BaseProxy
{
    /**
     * Returns the real enum class FQCN
     *
     * @return string
     */
    public static function enumClass()
    {
        $instance = static::getInstance();

        return $instance->targetClass();
    }

    /**
     * @inheritDoc
     */
    protected function targetClass(): string
    {
        return $this->concord->enum($this->contract);
    }

    /**
     * Tries guessing the associated contract class for an actual proxy class
     * Depending on the convention used by concord, the default pattern is
     * 'UserTypeProxy' -> enum == 'UserType' -> '../Contracts/UserType'
     *
     * @return string
     */
    protected function guessContract()
    {
        return $this->concord->getConvention()->contractForEnum(
            $this->concord->getConvention()->enumForProxy(static::class)
        );
    }
}
