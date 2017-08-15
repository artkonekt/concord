# Boxes

> Boxes are optional parts of the ecosystem. You can completely omit them if you see no benefits.

Boxes are actually modules too, thus they're also built around Laravel Service Providers.

## Difference Between Modules And Boxes

- **Modules are autonomous units built around a simple purpose** (eg. addressing or promotions) with as few external dependencies as possible.
- **Boxes are wrapping several modules and define inter-modular behavior**.

Boxes are composed from modules (they encapsulate them), and define how
these modules cooperate.

Think of boxes as re-usable application boilerplates, that are ready to be
used and customized. Another approach is to consider boxes as "glue" modules: they incorporate several independent modules and define the relationship between them.

Boxes are almost-ready applications, but they only live within the actual
Laravel application.

Applications can either originate from a single box, or from multiple boxes, the same way as apps can incorporate arbitrary number of modules.

## Explained

Say your organization has developed the following modules:

- product
- shipping
- payment
- billing
- client
- orders
- cart

As an example you can create two separate boxes of these:

1. An **Invoicing Box** (from client, product and billing modules)
2. A **Webshop Box** (from client, product, payment, shipping, orders and cart modules)

Your company may provide a standalone Invoicing solution, where the boilerplate "glue" logic is kept in the Invoicing box.
For specific clients you can do the customization within their own applications built **on top of the Invoicing Box**.

For other clients you can implement ecommerce apps on the top of the **Webshop Box**.
Any improvement that's not client specific goes back to the box and the underlying modules.
You can keep your client specific applications up to date with the box, since boxes are separate composer packages. It's something like updating WordPress while keeping all the client stuff in the theme.

What you can also do is to create an **application that contains
both boxes**, and from the client's perspective they constitute **a single system**.

## Parts To Be Included In Boxes

- Boxes **should only** define models, migrations that "glue" module parts together.
- Boxes **may gather and publish** models and migrations from underlying modules.
- Boxes **should not** define new repositories but **may extend** existing ones.
- Boxes **are expected to** define views, routes, resources, controllers, listeners, event bindings, request types.
- Boxes **should** bind repository interfaces to implementations.
- Boxes **may define** commands, middlewares, helpers and notifications.

## Module Folder Structure

#### Minimum Fileset For A Concord Module

```
box-src/
    Providers/
        |-- ModuleServiceProvider.php
    resources/
        |-- manifest.php
    
```

#### Full Stack Of Recommended File/Folder Structure
 
```
box-src/
    Console/
    Exceptions/
    Helpers/
    Http/
        |-- Controllers/
        |-- Middleware/
        |-- Requests/
    Jobs/
    Listeners/
    Models/
    Providers/
        |-- ModuleServiceProvider.php
        |-- EventServiceProvider.php
    Services/
    Tests/
        |-- Feature
        |-- Unit
    resources/
        |-- assets/
        |-- config/
            |-- box.php
        |-- lang/
        |-- routes/
            |-- api.php
            |-- web.php
        |-- views/
        |-- manifest.php
    
```

**Next**: [Creating Boxes &raquo;](creating-boxes.md)