# Entities

> Note: this part is not implemented only contains some ideas thrown in it.

Entities are Eloquent models, optionally "aggregated" by boxes or the application in the `app/Entities` folder (under `App\Entities` namespace) (? -  to be decided).

The approach is somewhat similar to what Doctrine v1 did use (eg. User extends BaseUser), so the `app/Entities` is rather a proxy folder, which typically extends entity classes defined in modules.

This way apps can easily modify the entities defined by the modules, and they'll be in a single folder

#### Next: [Repositories &raquo;](repositories.md)