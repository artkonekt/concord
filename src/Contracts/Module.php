<?php
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
use Konekt\Concord\Module\Manifest;

interface Module
{

    /**
     * Returns the id of the module (eg. foovendor.barmodule)
     *
     * @return string
     */
    public function getId(): string;

    /**
     * Returns the module's manifest object
     *
     * @return Manifest
     */
    public function getManifest(): Manifest;

    /**
     * Returns the root folder on the filesystem containing the module
     *
     * @return string
     */
    public function getBasePath(): string;

    /**
     * Returns the module's root (topmost) namespace
     *
     * @return string
     */
    public function getNamespaceRoot(): string;

    /**
     * Returns the kind of the module (box/module)
     *
     * @return Kind
     */
    public function getKind(): Kind;
}
