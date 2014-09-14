<?php
namespace adrianclay\xbrl\Taxonomy;


class Resource {

    /** @var \DOMElement */
    protected $element;

    /**
     * @param \DOMElement $element
     */
    public function __construct( \DOMElement $element )
    {
        $this->element = $element;
    }


    /**
     * @return string
     */
    public function getResourceLabel()
    {
        return $this->element->getAttributeNS( 'http://www.w3.org/1999/xlink', 'label' );
    }

    /**
     * @return string
     */
    public function getRole()
    {
        return $this->element->getAttributeNS( 'http://www.w3.org/1999/xlink', 'role' );
    }
}