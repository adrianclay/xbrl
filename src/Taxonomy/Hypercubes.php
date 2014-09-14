<?php
namespace adrianclay\xbrl\Taxonomy;

class Hypercubes extends \FilterIterator
{
    /**
     * @param Set $set
     */
    public function __construct( Set $set )
    {
        $this->set = $set;
        parent::__construct( $set->getConcepts() );
    }

    /**
     * @return bool
     */
    public function accept()
    {
        /** @var NamespaceName $substitutionGroup */
        $substitutionGroup = parent::current()->getSubstitutionGroup();
        return $substitutionGroup->getNamespace() == "http://xbrl.org/2005/xbrldt" && $substitutionGroup->getName() == "hypercubeItem";
    }

    /**
     * @return Hypercube
     */
    public function current()
    {
        return new Hypercube( $this->set, parent::current() );
    }
}