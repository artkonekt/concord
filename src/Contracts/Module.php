<?php

declare(strict_types=1);

/**
 * Contains the Module Interface.
 *
 * @copyright   Copyright (c) 2016 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2016-12-29
 *
 */

namespace Konekt\Concord\Contracts;

use Konekt\Concord\Module\Kind;

interface Module
{
    public static function getId(): string;

    public static function getConvention(): Convention;

    public function getName(): string;

    public function getVersion(): ?string;

    public function getBasePath(): string;

    public function getNamespaceRoot(): string;

    public function getKind(): Kind;

    /**
     * Returns module configuration value(s)
     *
     * @param string $key If left empty, the entire module configuration gets retrieved
     * @param mixed  $default
     *
     * @return mixed
     */
    public function config(string $key = null, mixed $default = null): mixed;

    /**
     * Returns the short (abbreviated) name of the module
     * E.g. Konekt\AppShell => app_shell
     */
    public function shortName();
}
