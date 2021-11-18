<?php

declare(strict_types=1);

/**
 * Contains the ModuleIdGenerator class.
 *
 * @copyright   Copyright (c) 2021 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2021-11-13
 *
 */

namespace Konekt\Concord\Utils;

use Illuminate\Support\Arr;
use Konekt\Concord\Contracts\Convention;

final class ModuleIdGenerator
{
    /**
     * Returns a standard module name based on the module provider's classname
     *
     * Eg.: '\Vendor\Module\Providers\ModuleServiceProvider' -> 'vendor.module'
     *      'App\Modules\Billing'                            -> 'billing'
     */
    public static function idOfClass(string $classname, ?Convention $convention = null): string
    {
        $convention = $convention ?: concord()->getConvention();
        $modulesFolder = $convention->modulesFolder();
        // Check if '\Modules\' is part of the namespace
        $p = strrpos($classname, "\\$modulesFolder\\");
        // if no \Modules\, but starts with 'Modules\' that's also a match
        $p = false === $p ? strpos($classname, "$modulesFolder\\") : $p;
        if (false !== $p) {
            $parts = explode('\\', substr($classname, $p + strlen($modulesFolder) + 1));
            $vendorAndModule = empty($parts[0]) ? Arr::only($parts, 1) : Arr::only($parts, 0);
        } else {
            $parts = explode('\\', $classname);
            $vendorAndModule = empty($parts[0]) ? Arr::only($parts, [1,2]) : Arr::only($parts, [0,1]);
        }

        array_walk($vendorAndModule, function (&$part) {
            $part = mb_strtolower($part);
        });

        return implode('.', $vendorAndModule);
    }
}
