<?php

namespace adrianclay\xbrl\Taxonomy;

class Dimension
{
    /** @var \adrianclay\xbrl\Taxonomy\Set */
    private $set;

    /** @var \adrianclay\xbrl\Taxonomy\Concept */
    private $concept;

    public function __construct(Set $set, Concept $dimension)
    {
        $this->set = $set;
        $this->concept = $dimension;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->concept->getName();
    }

    /**
     * @return Domain[]
     */
    public function getDomains()
    {
        $dimensions = new \AppendIterator();
        $set = $this->set;
        foreach ($this->set->getArcsFromConcept($this->concept)  as $arc) {
            if ('http://xbrl.org/int/dim/arcrole/dimension-domain' == $arc->getArcRole() && $arc instanceof Definition\Arc) {
                $dimensions->append(new \ArrayIterator(array_map(function (NamespaceId $id) use ($set) {
                    return new Domain($set, $set->getConcept($id));
                }, $arc->getToConcepts())));
            }
        }

        return $dimensions;
    }
}
