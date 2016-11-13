# Concord Modules

Modules are decoupled components and are glued together by the
[application](application.md) (or by a [box](boxes.md)).

There are basically two kinds of modules:

- external modules (separate composer packages)
- in-app modules (usually under `app/Modules/<ModuleName>`)

Technically there's no difference between the two.

## Why Modules?

Concord was written with extensible modules in mind. You may have code you're copypasting from one project to another, or even worse - starting from scratch over and over with minimal changes again.
These repeating units can be outsourced to modules and can be used across several applications that use those modules in a specific, custom manner.

As an example you may have an in-house CMS module that can handle pages, posts in multiple languages. App "A" only want the pages feature in a single language while app "B" wants all the CMS features. Then comes your client of app "A" and says they want to assign a specific color to each page. You can decide whether you want to implement this in your common CMS module or just for app "B". With Concord you shall be able to do either of those.

Modules can have different [parts](parts.md) like model classes, entities, controllers, config files, migrations, views, routes, middleware, frontend assets and so on.

Laravel itself solves many of these problems, so whenever a solution in the framework exists, it's being used. 


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