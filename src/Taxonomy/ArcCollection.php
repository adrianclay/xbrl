<?php
namespace adrianclay\xbrl\Taxonomy;

abstract class ArcCollection extends \ArrayIterator {

    /** @var \adrianclay\xbrl\Taxonomy\LinkBase */
    protected $linkBase;

    /** @var \DOMElement */
    protected $element;

    public function __construct( LinkBase $linkBase, \DOMElement $element )
    {
        $this->linkBase = $linkBase;
        $this->element = $element;
        parent::__construct( $this->getArcs() );
    }

    /**
     * @return string
     */
    public function getRole()
    {
        return $this->element->getAttributeNS( 'http://www.w3.org/1999/xlink', 'role' );
    }

    private $locations = null;
    public function getHrefs( $locatorLabel )
    {
        if ( is_null( $this->locations ) ) {
            $locations = array();
            $results = $this->element->getElementsByTagNameNS( 'http://www.xbrl.org/2003/linkbase', 'loc' );
            /** @var $result \DOMElement */
            foreach ( $results as $result ) {
                $label = $result->getAttributeNS( 'http://www.w3.org/1999/xlink', 'label' );
                $locations[$label] = empty( $locations[$label] ) ? array() : $locations[$label];
                $locations[$label][] = $this->linkBase->getConceptId( $result->getAttributeNS( 'http://www.w3.org/1999/xlink',
                                                                                               'href' ) );
            }
            $this->locations = $locations;
        }
        return $this->locations[$locatorLabel];
    }

    protected abstract function getArcs();
}