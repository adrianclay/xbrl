<?php

namespace adrianclay\xbrl\Taxonomy;

class Hypercubes extends \FilterIterator
{
    private $set;

    public function __construct(Set $set)
    {
        $this->set = $set;
        parent::__construct($set->getConcepts());
    }

    /**
     * @return bool
     */
    public function accept()
    {
        /** @var NamespaceName $substitutionGroup */
        $substitutionGroup = parent::current()->getSubstitutionGroup();

        return 'http://xbrl.org/2005/xbrldt' == $substitutionGroup->getNamespace() && 'hypercubeItem' == $substitutionGroup->getName();
    }

    /**
     * @return Hypercube
     */
    public function current()
    {
        return new Hypercube($this->set, parent::current());
    }
}
