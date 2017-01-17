# Helpers

Freely based on the idea of Magento helpers. These kinds of classes are
often required in views where using namespaces isn't very elegant, and
pushing instances from controllers would just increase noise.

So Concord's idea is that helpers are generally just services registered
in the service container but they can be reached via an abbreviated call
like `helper('money')->helperMethod()` or if you register the Helper
facade `Helper::get('money')->helperMethod()`.

#### Next: [Blade Components &raquo;](blade-components.md)