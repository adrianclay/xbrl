<?php
namespace adrianclay\xbrl\Taxonomy;

class NamespaceName {

    /** @var string */
    public $namespace;

    /** @var string */
    public $name;

    /**
     * @param string $namespace
     * @param string $name
     */
    public function __construct( $namespace, $name )
    {
        $this->namespace = $namespace;
        $this->name = $name;
    }

    /**
     * @param \DOMElement $element
     * @param string $text
     * @return NamespaceName
     */
    public static function create( \DOMElement $element, $text )
    {
        list( $prefix, $name ) = explode( ':', $text );
        $namespace = $element->lookupNamespaceUri( $prefix );
        return new NamespaceName( $namespace, $name );
    }

}