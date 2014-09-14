XBRL
====

[![Build Status](https://travis-ci.org/adrianclay/xbrl.svg?branch=master)](https://travis-ci.org/adrianclay/xbrl)

A simple API to parse XBRL taxonomies in PHP.

Usage
-----

A taxonomy is a set of XML files:

```php
use adrianclay\xbrl\Taxonomy\Set;

$taxonomy = new Set;
$taxonomy->import( 'Path to taxonomy', 'farming.xsd' );
foreach( $taxonomy->getConcepts() as $concept ) {
    echo $concept->getNamespace(), ": ", $concept->getName(), "\n";
}
```

Might give

    http://www.example.com/farming/: CowsSlaughtered
    http://www.example.com/farming/: CalvesBorn