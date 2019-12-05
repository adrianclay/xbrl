<?php

namespace adrianclay\xbrl\Taxonomy;

class Reference extends Resource
{
    /**
     * @return string
     */
    public function getContent()
    {
        return $this->element->nodeValue;
    }
}
