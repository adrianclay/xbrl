<?php

namespace adrianclay\xbrl\Taxonomy;

class Domain
{
    /** @var \adrianclay\xbrl\Taxonomy\Set */
    private $set;

    /** @var \adrianclay\xbrl\Taxonomy\Concept */
    private $concept;

    public function __construct(Set $set, Concept $domain)
    {
        $this->set = $set;
        $this->concept = $domain;
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
    public function getMembers()
    {
        $dimensions = new \AppendIterator();
        $set = $this->set;
        foreach ($this->set->getArcsFromConcept($this->concept) as $arc) {
            if ('http://xbrl.org/int/dim/arcrole/domain-member' == $arc->getArcRole() && $arc instanceof Definition\Arc) {
                $dimensions->append(new \ArrayIterator(array_map(function (NamespaceId $id) use ($set) {
                    return new Domain($set, $set->getConcept($id));
                }, $arc->getToConcepts())));
            }
        }

        return $dimensions;
    }
}
