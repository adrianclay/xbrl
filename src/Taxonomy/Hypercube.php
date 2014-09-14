<?php
namespace adrianclay\xbrl\Taxonomy;


class Hypercube {

    /** @var \adrianclay\xbrl\Taxonomy\Concept */
    private $concept;

    /** @var \adrianclay\xbrl\Taxonomy\Set */
    private $set;

    /**
     * @param Set $set
     * @param Concept $concept
     */
    public function __construct( Set $set, Concept $concept )
    {
        $this->set = $set;
        $this->concept = $concept;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->concept->getName();
    }

    /**
     * @return string
     */
    public function getNamespace()
    {
        return $this->concept->getNamespace();
    }


    /**
     * @return Dimension[]
     */
    public function getDimensions()
    {
        $dimensions = new \AppendIterator();
        $set = $this->set;
        foreach( $this->set->getArcsFromConcept( $this->concept ) as $arc ) {
            if ( $arc->getArcRole() == "http://xbrl.org/int/dim/arcrole/hypercube-dimension" && $arc instanceof Definition\Arc ) {
                $dimensions->append( new \ArrayIterator( array_map( function( NamespaceId $id ) use ( $set ) {
                    return new Dimension( $set, $set->getConcept( $id ) );
                }, $arc->getToConcepts() ) ) );
            }
        }
        return $dimensions;
    }
}