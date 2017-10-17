# Prologue

> If you're not interested in the story and philosophy behind, you may want to directly skip to the next part: [Overview &raquo;](overview.md)

## Main Goals

- Provide a platform on top of Laravel for extensible business applications.
- Establish the foundation for layered applications.
- Provide a system for using/creating a plugin-like modular architecture.
- Have a system that can embrace decoupled modules, so that we can get rid of duplications across projects.
- Establish a framework where specific modules can be customized, or even replaced.
- Standardize usage of Eloquent models and so that they can easily be extended/customized in final applications.

## Main Considerations

- Laravel 5.4+
- Follow Laravel's standards and practices.
- Don't duplicate functionality that exists in Laravel
- Keep the developer's liberty so that it's not a nightmare to implement/customize things.
- One thing should be done one way.
- Avoid over-engineering.
- DDD but ActiveRecord :)

## Inspirations

- [Monolithic vs. modular - what's the difference?](https://gist.github.com/joepie91/7f03a733a3a72d2396d6)
- [Creating a Modular Application in Laravel 5.1](http://kamranahmed.info/blog/2015/12/03/creating-a-modular-application-in-laravel/)
- [Modular Structure in Laravel 5](https://ziyahanalbeniz.blogspot.ro/2015/03/modular-structure-in-laravel-5.html)
- [Caffeinated Modules](https://github.com/caffeinated/modules)
- [Caffeinated Presenters](https://github.com/caffeinated/presenter)
- [Caffeinated Themes](https://github.com/caffeinated/themes)
- [Caffeinated Repository](https://github.com/caffeinated/repository)
- [Symfony Bundles](http://symfony.com/doc/bundles/)
- [Sylius Resource Component](https://github.com/Sylius/Resource)
- https://github.com/creolab/laravel-modules

## Who Is It For?

Concord adds some features **and therefore additional complexity** to the Laravel Framework. So think twice if you really need it.

#### Concord _is not_ for you if
most of these apply to you:

- "_I'm writing one simple application._"
- "_I have no need of code reuse in multiple applications._"
- "_My code is organized enough._"
- "_I know how to write my stuff, and I'm OK with it._"
- "_The amount I'm copypasting is fine._"
- "_Applications I develop have not too much in common._"
- "_I prefer to complete tasks as quickly as possible._"

#### Concord _is_ for you if
most of these apply to you:

- "_I **need** reusable business functionality._"
- "_I'm fed up with writing the same stuff over and over again._"
- "_My code organization isn't always consistent. One day a class of `Foo` might be a `Bar` the and the other day a `Baz`._"
- "_I often think about where to put a class._"
- "_Sometimes I look for code design advice on the net, but everything turns out to be relative._"
- "_Sometimes I'd be happy to have some guides on code organization and design._"
- "_I rather spend time **now** for creating something solid than to pay the price later._"
- "_Clean code is not about aesthetics but about robust systems._"

One of the main reasons I gave Concord birth for was my need for **Reusable
Business Functionality**. In most of the cases there's no need for that.

Recommended reading: [10 Modern Software Over-Engineering Mistakes](https://medium.com/@rdsubhas/10-modern-software-engineering-mistakes-bc67fbef4fc8).

OK, you've been warned :)

**Next**: [Overview &raquo;](overview.md)