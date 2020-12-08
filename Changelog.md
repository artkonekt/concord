# Concord Changelog

## 1.X Series

### 1.10.0
##### 2020-12-08

- Registering camel case route model bindings as well, ie. not only `product_type` but also `productType`
- Switched CI from travis to Github Actions

### 1.9.0
##### 2020-11-28

- Dropped PHP 7.2 support
- Dropped Laravel 5 support
- Added PHP 8 Support

### 1.8.0
##### 2020-09-12

- Added Laravel 8 support

### 1.7.0
##### 2020-08-31

- Added generic concord config for disabling automatic Route::model registration

### 1.6.0
##### 2020-06-20

- Added support for cascading config values to all submodules in boxes
- Changed the default of loading migrations of submodules: it defaults to the box's config (until 1.5 it defaulted to true)
- Added automatic publishing of module migrations
- Added automatic publishing of box + submodule migrations at boxes
- Added publish tag `own-migrations-only` for boxes to exclude the migrations of its submodules.

### 1.5.1
##### 2020-03-19

- Allowing enum v3.0 as well (v2.1+ is still supported)

### 1.5.0
##### 2020-03-13

- Dropped PHP 7.1 Support
- Added PHP 7.4 Support
- Added Laravel 7 support

### 1.4.0
##### 2019-11-17

- Added Laravel 6 support
- Dropped Laravel 5.4 support

### 1.3.1
##### 2019-06-08

- Annotations have been added to ModelProxy (for IDE autocompletion)

### 1.3.0
##### 2019-06-05

- Dropped PHP 7.0 support
- Added PHP 7.3 support
- Added Laravel 5.7 and 5.8 support

### 1.2.0
##### 2018-08-11

- Modules can be retrieved by id

### 1.1.0
##### 2018-02-18

- Laravel 5.6 support
- PHPUnit 7.0 support


### 1.0.0
##### 2018-01-17

- Documentation finished for 1.0.
- `BaseRequest` contract has been added (for form requests);
- Module kind gets obtained from the module not from the manifest. As a
  consequence it's no more needed (and has no effect) to specify the module kind
  in the manifest file
- Dist-type zipballs no more contain test, docs and other files that aren't
  needed for production

## 0.9 Series

### 0.9.10
##### 2017-12-11

- List enums and requests commands have been added


### 0.9.9
##### 2017-12-08

- Enum-eloquent bumped to 1.1.3+ (bugfix)
- PHP 7.2 is supported

### 0.9.8
##### 2017-11-24

- Enum version bumped to 2.1+ and enum-eloquent to 1.1.2+


### 0.9.7
##### 2017-10-09

- Laravel 5.3 support has been dropped
- Full Laravel 5.5 support

### 0.9.6
##### 2017-10-06

- The [enum-eloquent](https://github.com/artkonekt/enum-eloquent) package has been added

### 0.9.5
##### 2017-09-18

- Fixed stale concord instance in proxies (only happened during tests)
- Modules collection is now stored with module id as key
- Doc updates
- Concord Events have been introduced

### 0.9.4
##### 2017-09-13

- Konekt Enum requirement bumped to v2.0

### 0.9.3
##### 2017-08-15

- Documentation updated + converted from jekyll to docsify

### 0.9.2
##### 2017-07-26

- On concord model registration route models are registered by default (with short name)

### 0.9.1
##### 2017-07-09

- Laravel 5.5 auto-discovery support
- fixes, doc updates
- Support for model/enum/request shorts,
- `enum('short_name')` helper

### 0.9.0
##### 2017-06-14

- First version ever tagged, Changelog started
- 0.9.x series are pre-1.0 versions, feature set is expected to be intact until 1.0
- Documentation needs review
- Test coverage is only ~42%
- Contains the following features:
    - Modules & Boxes with manifest
    - Modules are singular, boxes can incorporate other modules
    - Loading of views, routes migrations, models/enums/requests & event-service providers can be turned on/of in module config
    - Directory/Namespace layout is driven by conventions
    - Flexible models, enums & requests (via proxies)
    - Helpers

