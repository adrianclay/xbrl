<?php
namespace adrianclay\xbrl\Taxonomy\Definition;
use \adrianclay\xbrl\Taxonomy\ArcCollection;

class Link extends ArcCollection {

    /**
     * @return Arc[]
     */
    protected function getArcs()
    {
        $arcs = array();
        $results = $this->element->getElementsByTagNameNS( 'http://www.xbrl.org/2003/linkbase', 'definitionArc' );
        foreach( $results as $result )
        {
            $arcs[] = new Arc( $this, $result );
        }
        return $arcs;
    }


}