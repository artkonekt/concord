# Module Versions

> This page is a draft and is a subject of analysis. Anything here is a subject to change.
> 
> @todo Once it's final, add it to `_sidebar.md`

## Concord v1.x

- In Concord v1 every package had to have a version defined in its manifest file.
- It makes complete sense when a module is kept in a separate composer package.
- However, even there, the version is actually available in composer (and would be accessible using https://github.com/Ocramius/PackageVersions)
- When using in-app modules, this module version is either completely useless or simply redundant.
- Most applications have a version - for the entire application, but not for their modules.
- In most of the cases, the in-app module version number has simply remained `0.1.0` forever

## Concord v2.x

In Concord version 2, the following shortcomings have to be addressed:

- Don't enforce the module version, especially when using in-app modules
- Make version optional
- Check if package based modules can read their version information from composer
- Optionally make the module be aware of its composer package (what about forks?)

### Possible Solution

- The version is no longer mandatory
- The manifest file can still have version
- Get rid of the manifest class
- Move getName and getVersion from Manifest class to the Module interface
- When there's no version getVersion returns null
- Make it possible for modules to retrieve their version number from composer
- The composer version retrieval requires "composer/composer: ^2.0" to be added to the dependency list since `Composer\InstalledVersions` was added there.
- This also requires of storing the modules' composer package name somewhere (likely in manifest)
- Strategy could be the following:
  1. If a package has version in manifest - we use that
  2. If a package has no version in manifest, but there's a composer package name - we look it up from there
  3. If neither version nor package name, we just return NULL

```php
InstalledVersions::getPrettyVersion('konekt/concord')
// dev-master or 1.10.1
```
