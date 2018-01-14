# Map Of Concord Parts

> **Note: _This is a recommendation_**, not a mandatory ruleset.

This is the cheat sheet for Concord's intended structure.
It shows, where specific parts should be placed, implemented or customized

| Part                          | Module |  Box  | Application |
|-------------------------------|:------:|:-----:|:-----------:|
| Configuration                 |   D    |  G,P  |      O      |
| Migrations                    |   D    |  G,P  |     D,I     |
| Entities                      |   D    |  G,P  |     D,O     |
| Events                        |   D    |   D   |      D      |
| Listeners                     |   -    |   D   |      D      |
| Event-Listener Bindings       |   -    |   D   |    D,O,I    |
| Helpers                       |   D    |   D   |    D,E,O    |
| Blade Components              |   D    |  D,O  |     D,O     |
| Views                         |   -    |  D,P  |     D,O     |
| Routes                        |   -    |  D,P  |    D,O,I    |
| Resources (assets, lang, etc) |   -    |  D,P  |    D,O,I    |
| Controllers                   |   -    |   D   |    D,B,O    |
| Commands                      |   -    |   D   |     D,O     |
| API Resources                 |   D    |  D,O  |     D,O     |
| Middlewares                   |   -    |   D   |     D,O     |
| Requests (specific)           |   A    | D,O,I |      O      |
| Notifications                 |   -    |   D   |     D,O     |


##### Legend

|        |               |                                                                        |
|--------|---------------|------------------------------------------------------------------------|
| **D**: | Defines       | To be defined and implemented here                                     |
| **A**: | Abstract Only | Can be defined here, but only as abstract                              |
| **G**: | Gathers       | Gathers these parts from a lower lever layer                           |
| **P**: | Publishes     | Publishes part(s) to an upper lever layer                              |
| **O**: | Overrides     | Overrides part from a lower level layer                                |
| **I**: | Ignores       | May ignore these parts from a lower level layer                        |
| **E**: | Extends       | May extend these parts from a lower level layer                        |
| **B**: | Binds         | Binding of interfaces to concrete implementation happens in this layer |
