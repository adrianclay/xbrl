<?php
namespace adrianclay\xbrl\Taxonomy;

class Label extends Resource
{

    /**
     * @return string
     */
    public function getLang()
    {
        return $this->element->getAttributeNS( 'http://www.w3.org/XML/1998/namespace', 'lang' );
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->element->nodeValue;
    }
}