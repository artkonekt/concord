# Prologue

> If you're not interested in the story and philosophy behind, you may want to directly skip to the next part: [Overview &raquo;](overview.md)

## Main Goals

- Provide an extensible PHP platform for business applications
- To establish the foundation for layered applications
- Provide a system for using/creating a plugin-like modular architecture
- Have a system that can embrace decoupled modules, so that we can get rid of duplications across projects
- Define the inverse (but not opposite) of the SOLID principle: one thing should be done one way
- Use all the goodness and best practices of Laravel 5.3+
- Standardize entities and their related design patterns (repositories, factories, etc)
- DDD but ActiveRecord :)
- Establish a framework where specific modules can be customized, or even replaced
- Avoid over-engineering
- Keep the developer's liberty so that it's not a nightmare to implement/customize things

## Inspirations

- [Symfony Bundles](http://symfony.com/doc/bundles/)
- [Sylius Resource Component](https://github.com/Sylius/Resource)
- [Creating a Modular Application in Laravel 5.1](http://kamranahmed.info/blog/2015/12/03/creating-a-modular-application-in-laravel/)
- [Modular Structure in Laravel 5](https://ziyahanalbeniz.blogspot.ro/2015/03/modular-structure-in-laravel-5.html)
- [Caffeinated Modules](https://github.com/caffeinated/modules)
- [Caffeinated Presenters](https://github.com/caffeinated/presenter)
- [Caffeinated Themes](https://github.com/caffeinated/themes)
- [Caffeinated Repository](https://github.com/caffeinated/repository)
- https://github.com/creolab/laravel-modules

## Who Is It For?

This creation is an engineering shit so think twice if you really need it.

##### Concord is _not_ for you if
most of these apply to you:

- "_My code is organized enough._"
- "_I know how to write my stuff, and I'm OK with it._"
- "_The amount I'm copypasting is fine._"
- "_I'm fed up with interfaces and abstractions._"
- "_Rules only chain me._"
- "_In real life, every application is **very** different._"
- "_I prefer to complete tasks as quickly as possible._"
- "_Code beauty is bullshit._"

##### Concord is for you if
most of these apply to you:

- "_Something smells with the organization of my code_"
- "_Sometimes I look for code design advice on the net, but everything turns out to be relative._"
- "_I'm fed up with writing the same stuff over and over again._"
- "_The way I'm using abstracts, traits and interfaces is not solid._"
- "_Sometimes I'd be happy to have some guides on code organization and design._"
- "_I often keep thinking where to put a class._"
- "_I **need** reusable business functionality._"
- "_I rather spend time **now** for creating something solid than to pay the price later._"
- "_Clean code is not about aesthetics but about robust systems._"

One of the main reasons I gave Concord birth for was my need for **Reusable
Business Functionality**. In most of the cases there's no need for that.

Recommended reading: [10 Modern Software Over-Engineering Mistakes](https://medium.com/@rdsubhas/10-modern-software-engineering-mistakes-bc67fbef4fc8).

#### Next: [Overview &raquo;](overview.md)