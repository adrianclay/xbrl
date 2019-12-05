<?php

namespace adrianclay\xbrl\Taxonomy;

class NamespaceName
{
    /** @var string */
    private $namespace;

    /** @var string */
    private $name;

    /**
     * @param string $namespace
     * @param string $name
     */
    public function __construct($namespace, $name)
    {
        $this->namespace = $namespace;
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getNamespace()
    {
        return $this->namespace;
    }

    /**
     * @param string $text
     *
     * @return NamespaceName
     */
    public static function create(\DOMElement $element, $text)
    {
        list($prefix, $name) = explode(':', $text);
        $namespace = $element->lookupNamespaceUri($prefix);

        return new NamespaceName($namespace, $name);
    }
}
