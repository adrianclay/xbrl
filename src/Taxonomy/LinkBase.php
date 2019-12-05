<?php

namespace adrianclay\xbrl\Taxonomy;

class LinkBase implements \IteratorAggregate
{
    /** @var Set */
    private $set;

    /** @var string */
    private $path;

    /** @var \DOMDocument */
    private $dom;

    /** @var ArcCollection[] */
    private $links;

    /**
     * @param string $path
     */
    public function __construct(Set $set, $path)
    {
        $this->set = $set;
        $this->path = $path;
        $this->dom = new \DOMDocument();
        $this->dom->load($path);
        $xpath = new \DOMXPath($this->dom);
        $xpath->registerNamespace('link', 'http://www.xbrl.org/2003/linkbase');
        $xpath->registerNamespace('linkbase', 'http://www.xbrl.org/2003/linkbase');
        $lls = [];
        /** @var $element \DOMElement */
        foreach ($xpath->evaluate('//link:linkbase/*') as $element) {
            switch ($element->nodeName) {
                case 'labelLink':
                    $lls[] = new Label\Link($this, $element);
                    break;
                case 'referenceLink':
                    $lls[] = new Reference\Link($this, $element);
                    break;
                case 'presentationLink':
                    $lls[] = new Presentation\Link($this, $element);
                    break;
                case 'calculationLink':
                    $lls[] = new Calculation\Link($this, $element);
                    break;
                case 'definitionLink':
                    $lls[] = new Definition\Link($this, $element);
                    break;
            }
        }
        $this->links = $lls;
    }

    /**
     * Converts a string from "file.xsd#interestingElement" into a NamespaceId object.
     *
     * @param string $href
     *
     * @return NamespaceId
     */
    public function getConceptId($href)
    {
        $parts = parse_url($href);
        $schema = $this->set->import(dirname($this->path), $parts['path']);

        return new NamespaceId($schema->getNamespace(), $parts['fragment']);
    }

    /**
     * @return ArcCollection[]
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->links);
    }
}
