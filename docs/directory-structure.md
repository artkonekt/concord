# Directory Structure

## Minimum Fileset For A Concord Module

```
module-src/
    Providers/
        |-- ModuleServiceProvider.php
    resources/
        |-- manifest.php
    
```

## Full Stack Of Recommended File/Folder Structure

> Note: the list below contains the folders for both boxes and modules, however it's recommended to only have parts, thus specific folders depending on its kind (module or box)

```
module-src/
    Console/
        Commands/
    Contracts/
    Events/
    Exceptions/
    Helpers/
    Http/
        |-- Controllers/
        |-- Middleware/
        |-- Requests/
    Jobs/
    Listeners/
    Models/
        |-- Entities/
        |-- Repositories/
        |-- Factories/
    Providers/
        |-- ModuleServiceProvider.php
        |-- EventServiceProvider.php
    Services/
    Tests/
        |-- Feature
        |-- Unit
    resources/
        |-- config/
            |-- module.php
            |-- box.php
        |-- database/
            |-- migrations/
            |-- seeds/
        |-- lang/
        |-- public/
            |-- assets/
        |-- routes/
            |-- api.php
            |-- web.php
        |-- views/
        |-- manifest.php
    
```

#### Next: [Concord Rules &raquo;](rules.md)