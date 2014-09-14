<?php
namespace adrianclay\xbrl\Taxonomy;


class Concept {

    /** @var Schema */
    private $parent;

    /** @var \DOMElement */
    private $element;

    /**
     *
     * @param Schema      $parent
     * @param \DOMElement $element
     */
    public function __construct( Schema $parent, \DOMElement $element )
    {
        $this->parent = $parent;
        $this->element = $element;
    }

    /**
     * @return string
     */
    public function getNamespace()
    {
        return $this->parent->getNamespace();
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->element->getAttribute( 'name' );
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->element->getAttribute( 'id' );
    }

    /**
     * @return NamespaceName
     */
    public function getType()
    {
        return NamespaceName::create( $this->element, $this->element->getAttribute( 'type' ) );
    }

    /**
     * @return NamespaceName
     */
    public function getSubstitutionGroup()
    {
        return NamespaceName::create( $this->element, $this->element->getAttribute( 'substitutionGroup' ) );
    }

    /**
     * @return string
     */
    public function getPeriodType()
    {
        return $this->element->getAttributeNs( 'http://www.xbrl.org/2003/instance', 'periodType' );
    }

    /**
     * @return string
     */
    public function getBalance()
    {
        return $this->element->getAttributeNs( 'http://www.xbrl.org/2003/instance', 'balance' );
    }
}