# Migrations

The migrations within Concord are just plain Laravel migrations. Starting with v5.3, Laravel supports migrations distributed in various folders, Concord is utilizing this facility.

Migrations are module level parts, since they belong to the model layer, are brothers and sisters with entities.

However customizations happen in the application layer, so migrations are naturally present there as well. Application level migrations should contain customizations that are **exclusively relevant** to the specific application/client.