<?php

namespace Drupal\graphql_metatag\Plugin\GraphQL\Types;

use Drupal\graphql\Plugin\GraphQL\Types\TypePluginBase;

/**
 * The GraphQL type.
 *
 * @GraphQLType(
 *   id = "meta_value",
 *   name = "MetaValue",
 *   interfaces = {"MetaTag"}
 * )
 */
class MetaValue extends TypePluginBase {
}
