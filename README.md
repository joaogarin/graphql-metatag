# GraphQL Metatag for Drupal

[![Build Status](https://img.shields.io/travis/drupal-graphql/graphql-metatag.svg)](https://travis-ci.org/drupal-graphql/graphql-metatag)
[![Code Coverage](https://img.shields.io/codecov/c/github/drupal-graphql/graphql-metatag.svg)](https://codecov.io/gh/drupal-graphql/graphql-metatag)
[![Code Quality](https://img.shields.io/scrutinizer/g/drupal-graphql/graphql-metatag.svg)](https://scrutinizer-ci.com/g/drupal-graphql/graphql-metatag/?branch=8.x-4.x)

Please refer to the main [Drupal GraphQL] module for further information.

[Drupal GraphQL]: https://github.com/drupal-graphql/graphql

## Installation

To install the module first make sure to install it via composer by running 

```composer require drupal/graphql-metatag```

After that enable the module as usual.

## GraphQL Schema & Data producer

The module ads a new data producer for resolving metatags out of entities, to use it first you need to add the schema
for your metatags. By default the module will resolve a type that contains 2 properties,
a meta (the meta tag) and value (the value for that metatag).

So Lets assume you have a node of type my_node which type is defined in the schema as `MyNode` that has a field `metatagInformation` :  

```graphql
type MyNode {
  metatagInformation: [Metatag]
}

type Metatag {
  meta: String
  value: String
}
```

to resolve that field you will need to call this data producer :

```php
$registry->addFieldResolver('MyNode', 'metatagInformation',
  $builder->produce('entity_metatag', [
    'mapping' => [
      'entity' => $builder->fromParent(),
    ],
  ])
);
```

Naturally due to the nature of the Drupal GraphQL 4.x version you could still resolve fields from this Metatag type
and change them to your own liking simply by resolving them on top of the existing ones. This way you can really define your schema exactly as you want it. Lets assume 
we wanted a Metatag type like this instead : 

```graphql
type MyNode {
  metatagInformation: [MetatagInformation]
}

type MetatagInformation {
  metaTag: String
  metaValue: String
}
```

```php
$registry->addFieldResolver('MyNode', 'metatagInformation',
  $builder->produce('entity_metatag', [
    'mapping' => [
      'entity' => $builder->fromParent(),
    ],
  ])
);

$registry->addFieldResolver('MetatagInformation', 'metaTag',
  new Callback(function ($metatag) {
    return $metatag['meta']
  })
);

$registry->addFieldResolver('MetatagInformation', 'metaValue',
  new Callback(function ($metatag) {
    return $metatag['value']
  })
);

```

