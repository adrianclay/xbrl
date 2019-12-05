<?php

namespace adrianclay\xbrl\Taxonomy\Label;

class Arc extends \adrianclay\xbrl\Taxonomy\Arc
{
    /**
     * @return \adrianclay\xbrl\Taxonomy\Label[]
     */
    public function getLabels()
    {
        /** @var Link $link */
        $link = $this->locatorCollection;

        return $link->getLabels($this->getTo());
    }
}
