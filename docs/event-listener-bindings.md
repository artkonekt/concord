# Event-Listener Bindings

Modules should not bind events to listeners, but boxes and apps are expected to do so.

Boxes may define their default event-listener bindings in their own
`Providers/EventServiceProvider.php` file.

The application may want to override these bindings.

As an example a forum box defines that a `CommentWasPosted` event is being
listened by `SendEmailToThreadSubscribers` and `IncreaseUserPostCount` listeners.
But the implementing app may want to omit sending these emails, so it can
override these bindings.

In case you want the module loader to register the module's
`EventServiceProvider` (which it doesn't do by default) you need add this to
the module's config file:

```php
<?php

return [
    'modules' => [
        Vendor\MyBox\Providers\ModuleServiceProvider::class => [
            'event_listeners' => true
        ]
    ]
];
```

**Next**: [Helpers &raquo;](helpers.md)
