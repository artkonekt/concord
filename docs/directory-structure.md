# Directory Structure

## Minimum Fileset For A Concord Module

```text
module-src/
    Providers/
        │
        └── ModuleServiceProvider.php
    resources/
        │
        └── manifest.php
    
```

## Full Stack Of Recommended File/Folder Structure

> Note: the list below contains the folders for both [boxes](boxes.md) and
> [modules](modules.md) for the sake of being a single reference.

The default locations are:

```text
module-src/
    Console/
        Commands/
    Contracts/
    Events/
    Exceptions/
    Factories/
    Helpers/
    Http/
      ├── Controllers/
      ├── Middleware/
      ├── Requests/
      └── Resources/
    Jobs/
    Listeners/
    Models/
    Notifications/ 
    Providers/
      ├── ModuleServiceProvider.php
      └── EventServiceProvider.php
    Services/
    Tests/
      ├── Feature
      └── Unit
    resources/
      ├── assets/
      └── config/
           ├── module.php
           └── box.php
      ├── database/
           ├── migrations/
           └── seeds/
      ├── lang/
      └── routes/
           ├── api.php
           └── web.php
      ├── views/
      └── manifest.php
    
```

This folder layout is stored in the `ConcordDefault`
[convention](conventions.md). You can customize this layout by overriding the
default convention (class).

**Next**: [Concord Rules &raquo;](rules.md)
