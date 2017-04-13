# Repositories

Since Eloquent is ActiveRecord, it already works as repository, so Concord repositories are just wrapping Eloquent models, but also add the possibility to create specific retrieval methods and query caching.

> Use of [query scopes](https://laravel.com/docs/5.4/eloquent#query-scopes) is encouraged.

Their more important role is however that repos are able to retrieve the actual AR models even if they've been replaced by an extended variant in an upper level layer (eg. your application).

#### Next: [Events &raquo;](events.md)