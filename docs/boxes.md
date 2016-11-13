# Boxes

Boxes are optional parts of the ecosystem.

Think of boxes as re-usable application templates, that are ready to be
used and to be customized. They can either be used as standalone apps,
or as a combination of multiple boxes.

Boxes are composed from modules (they encapsulate them), and define how
these modules cooperate.

Boxes are almost-ready applications, but they only live within the actual
Laravel application.

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
You can keep the client specific applications up to date with the box, since boxes are separate composer packages.

What you also can do is to create an **application that contains
both boxes**, and from the client's perspective they constitute **a single system**.

## Parts To Be Included In Boxes

- Boxes **must not** define entities, migrations and in general any module specific models.
- Boxes **must gather and publish** entities and migrations from underlying modules.
- Boxes **should not** define new repositories but **may extend** existing ones.
- Boxes **are expected to** define views, routes, resources, controllers, listeners, event bindings, request types.
- Boxes **should** bind repository interfaces to implementations.
- Boxes **may define** commands, middlewares, helpers and notifications.

#### Next: [Application &raquo;](application.md)