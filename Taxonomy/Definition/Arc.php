<?php
namespace adrianclay\xbrl\Taxonomy\Definition;

class Arc extends \adrianclay\xbrl\Taxonomy\Arc {

    /**
     * @return \adrianclay\xbrl\Taxonomy\NamespaceId[]
     */
    public function getToConcepts()
    {
        return $this->locatorCollection->getHrefs( $this->getTo() );
    }
}