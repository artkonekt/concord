# Event-Listener Bindings

Boxes may define their default event-listener bindings in their own `Providers/EventServiceProvider.php` file.

An app however, may want to override these bindings.

As an example a forum module defines that a `CommentWasPosted` event is being listened by `SendEmailToThreadSubscribers` and `IncreaseUserPostCount` listeners.

But the implementing app may want to omit sending these emails, so they can override these module bindings.

So in case you want the module loader to register the module's EventServiceProvider (which it doesn't do by default) you should add this to the module's config file:

```php
return [
    'concord' => [
        'loader' => [
            'register' => [
                'events_provider' => true
            ]
        ]
    ]
];
```
