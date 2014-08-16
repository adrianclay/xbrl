<?php
namespace adrianclay\xbrl\Taxonomy;


class Arc {

    /** @var \DOMElement */
    protected $element;

    /** @var ArcCollection  */
    protected $locatorCollection;

    /**
     * @param ArcCollection  $collection
     * @param \DOMElement        $element
     */
    public function __construct( ArcCollection $collection, \DOMElement $element )
    {
        $this->locatorCollection = $collection;
        $this->element = $element;
    }

    /**
     * @return NamespaceId[]
     */
    public function getFromConcepts()
    {
        return $this->locatorCollection->getHrefs( $this->getFrom() );
    }

    /**
     * @param NamespaceId $id
     * @return bool
     */
    public function isFrom( NamespaceId $id )
    {
        $isFrom = false;
        foreach( $this->getFromConcepts() as $from ) {
            $isFrom |= $from->id == $id->id && $from->namespace == $id->namespace;
        }
        return $isFrom;
    }

    /**
     * @return string
     */
    protected function getFrom()
    {
        return $this->element->getAttributeNS( 'http://www.w3.org/1999/xlink', 'from' );
    }

    /**
     * @return string
     */
    protected function getTo()
    {
        return $this->element->getAttributeNS( 'http://www.w3.org/1999/xlink', 'to' );
    }

    /**
     * @return string
     */
    public function getArcRole()
    {
        return $this->element->getAttributeNS( 'http://www.w3.org/1999/xlink', 'arcrole' );
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->element->getAttributeNS( 'http://www.w3.org/1999/xlink', 'title' );
    }

    /**
     * @return string
     */
    public function getOrder()
    {
        return $this->element->getAttributeNS( 'http://www.w3.org/1999/xlink', 'order' );
    }

    /**
     * @return bool
     */
    public function isOptional()
    {
        return $this->element->getAttributeNS( 'http://www.w3.org/1999/xlink', 'use' ) == 'optional';
    }
}