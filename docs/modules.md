# Concord Modules

Modules are decoupled components and are glued together by the
[application](application.md) (or by a [box](boxes.md)). Technically they're a bunch of classes and files wired into the Laravel Application with their own dedicated [Service Provider](https://laravel.com/docs/5.3/providers).

Modules can be situated in two ways:

- as external modules (separate composer packages)
- in-app modules (usually under `app/Modules/<ModuleName>`)

Technically there's no difference between the two.



## Module Folder Structure

#### Minimum Fileset For A Concord Module

```
module-src/
    Providers/
        |-- ModuleServiceProvider.php
    resources/
        |-- manifest.php
    
```

#### Full Stack Of Recommended File/Folder Structure
 
```
module-src/
    Contracts/
    Events/
    Exceptions/
    Helpers/
    Models/
        |-- Entities/
        |-- Repositories/
        |-- Factories/
    Providers/
        |-- ModuleServiceProvider.php
    Services/
    resources/
        |-- config/
            |-- module.php
        |-- database/
            |-- migrations/
            |-- seeds/
        |-- manifest.php
    
```

#### Next: [Boxes &raquo;](boxes.md)