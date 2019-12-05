<?php

namespace adrianclay\xbrl\Taxonomy;

class NamespaceId
{
    /** @var string */
    public $namespace;

    /** @var string */
    public $id;

    /**
     * @param string $namespace
     * @param string $id
     */
    public function __construct($namespace, $id)
    {
        $this->namespace = $namespace;
        $this->id = $id;
    }
}
