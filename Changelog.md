# Concord Changelog

## 0.9 Series

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

