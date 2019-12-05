<?php

namespace adrianclay\xbrl\Taxonomy\Reference;

class Arc extends \adrianclay\xbrl\Taxonomy\Arc
{
    /**
     * @return \adrianclay\xbrl\Taxonomy\Reference[]
     */
    public function getReferences()
    {
        /** @var Link $link */
        $link = $this->locatorCollection;

        return $link->getReference($this->getTo());
    }
}
