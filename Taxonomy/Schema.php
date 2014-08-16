<?php
namespace adrianclay\xbrl\Taxonomy;

class Schema
{
    /** @var \DOMDocument */
    protected $dom;

    /** @var Concept[] */
    protected $concepts = null;

    /**
     * @param string $path
     */
    public function __construct( $path )
    {
        $this->dom = new \DOMDocument();
        $this->dom->load( $path );
    }

    /**
     * @return string
     */
    public function getNamespace()
    {
        return $this->dom->documentElement->getAttribute( 'targetNamespace' );
    }

    /**
     * @return Concept[]
     */
    public function getConcepts()
    {
        if ( $this->concepts == null ) {
            $this->concepts = array();
            $xPath = new \DOMXPath( $this->dom );
            $xPath->registerNamespace( 'xsd', 'http://www.w3.org/2001/XMLSchema' );
            $xPath->registerNamespace( 'link', 'http://www.xbrl.org/2003/linkbase' );
            foreach( $xPath->evaluate( '//xsd:schema/xsd:element' ) as $element ) {
                $concept = new Concept( $this, $element );
                $this->concepts[$concept->getId()] = $concept;
            }
        }
        return $this->concepts;
    }

    /**
     * @param string $id
     * @return Concept
     */
    public function getConceptById( $id )
    {
        $concepts = $this->getConcepts();
        return $concepts[$id];
    }

    /**
     * @return \DOMNodeList
     */
    public function getImports()
    {
        $xPath = new \DOMXPath( $this->dom );
        $xPath->registerNamespace( 'xsd', 'http://www.w3.org/2001/XMLSchema' );
        return $xPath->evaluate( "//xsd:schema/xsd:import/@schemaLocation" );
    }

    /**
     * @return \DOMNodeList
     */
    public function getLinkbases()
    {
        $xPath = new \DOMXPath( $this->dom );
        $xPath->registerNamespace( 'xsd', 'http://www.w3.org/2001/XMLSchema' );
        $xPath->registerNamespace( 'link', 'http://www.xbrl.org/2003/linkbase' );
        $xPath->registerNamespace( 'xlink', 'http://www.w3.org/1999/xlink' );
        return $xPath->evaluate( "//xsd:schema/xsd:annotation/xsd:appinfo/link:linkbaseRef/@xlink:href" );
    }
}