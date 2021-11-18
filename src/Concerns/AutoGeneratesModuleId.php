<?php

declare(strict_types=1);

/**
 * Contains the AutoGeneratesModuleId trait.
 *
 * @copyright   Copyright (c) 2021 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2021-11-13
 *
 */

namespace Konekt\Concord\Concerns;

use Konekt\Concord\Contracts\Module;
use Konekt\Concord\Utils\ModuleIdGenerator;

trait AutoGeneratesModuleId
{
    protected static ?string $moduleId = null;

    public static function getId(): string
    {
        if (null === static::$moduleId) {
            static::$moduleId = static::moduleIdOfThisClass();
        }

        return static::$moduleId;
    }

    protected static function moduleIdOfThisClass(): string
    {
        if (is_a_concord_module_class(static::class)) {
            return ModuleIdGenerator::idOfClass(static::class, static::getConvention());
        }

        throw new \LogicException(
            'The %s class does not implement the %s interface',
            static::class,
            Module::class,
        );
    }
}
