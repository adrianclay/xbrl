<?php

namespace adrianclay\xbrl\Taxonomy\Reference;

use adrianclay\xbrl\Taxonomy\ArcCollection;
use adrianclay\xbrl\Taxonomy\Reference;

class Link extends ArcCollection
{
    /** @var Reference[][] */
    protected $references = null;

    /**
     * @return Arc[]
     */
    protected function getArcs()
    {
        $arcs = [];
        $results = $this->element->getElementsByTagNameNS('http://www.xbrl.org/2003/linkbase', 'referenceArc');
        foreach ($results as $result) {
            $arcs[] = new Arc($this, $result);
        }

        return $arcs;
    }

    /**
     * @param string $ref
     *
     * @return Reference[]
     */
    public function getReference($ref)
    {
        if (is_null($this->references)) {
            $references = [];
            $results = $this->element->getElementsByTagNameNS('http://www.xbrl.org/2003/linkbase', 'reference');
            foreach ($results as $result) {
                $reference = new Reference($result);
                $references[$reference->getResourceLabel()] = empty($references[$reference->getResourceLabel()]) ? [] : $references[$reference->getResourceLabel()];
                $references[$reference->getResourceLabel()][] = $reference;
            }
            $this->references = $references;
        }

        return $this->references[$ref];
    }
}
