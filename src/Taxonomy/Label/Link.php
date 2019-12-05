<?php

namespace adrianclay\xbrl\Taxonomy\Label;

use adrianclay\xbrl\Taxonomy\ArcCollection;
use adrianclay\xbrl\Taxonomy\Label;

class Link extends ArcCollection
{
    /** @var Label[] */
    private $labels = null;

    /**
     * @return Arc[]
     */
    protected function getArcs()
    {
        $arcs = [];
        $results = $this->element->getElementsByTagNameNS('http://www.xbrl.org/2003/linkbase', 'labelArc');
        foreach ($results as $result) {
            $arcs[] = new Arc($this, $result);
        }

        return $arcs;
    }

    /**
     * @param string $reference
     *
     * @return Label[]
     */
    public function getLabels($reference)
    {
        if (is_null($this->labels)) {
            $labels = [];
            $results = $this->element->getElementsByTagNameNS('http://www.xbrl.org/2003/linkbase', 'label');
            foreach ($results as $result) {
                $label = new Label($result);
                $labels[$label->getResourceLabel()] = empty($labels[$label->getResourceLabel()]) ? [] : $labels[$label->getResourceLabel()];
                $labels[$label->getResourceLabel()][] = $label;
            }
            $this->labels = $labels;
        }

        return $this->labels[$reference];
    }
}
