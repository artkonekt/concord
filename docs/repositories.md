# Repositories

> Note: this part is not implemented only contains some ideas thrown in it.

Concord Repositories are [collection oriented](http://shawnmc.cool/the-repository-pattern#collection-oriented-vs-persistence-oriented),
thus only to be used for data retrieval; persistence (store, update, delete) should be done directly via the model.

Use of [query scopes](https://laravel.com/docs/5.3/eloquent#query-scopes) is encouraged, repositories should wrap them.

#### Next: [Events &raquo;](events.md)