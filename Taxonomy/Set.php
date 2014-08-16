<?php
namespace adrianclay\xbrl\Taxonomy;

class Set {

    /** @var string[] */
    private $realPathToImport = array();

    /** @var Schema[] */
    private $imports = array();

    /** @var LinkBase[] */
    private $linkbases = array();

    /** @var Arc[][][] */
    private $arcCache = null;

    /**
     * @param string $basePath
     * @param string $schemaLocation
     * @return Schema
     */
    public function import( $basePath, $schemaLocation )
    {
        $p = parse_url( $schemaLocation );
        if ( empty( $p['scheme'] ) ) {
            $schemaLocation = realpath( $basePath . '/' . $p['path'] );
            if ( !empty( $this->realPathToImport[$schemaLocation] ) ) {
                return $this->imports[$this->realPathToImport[$schemaLocation]];
            }
            $dom = new Schema( $schemaLocation );
            $basePath = dirname( $schemaLocation );
            foreach( $dom->getImports() as $import ) {
                $this->import( $basePath, $import->value );
            }
            foreach( $dom->getLinkbases() as $import ) {
                $this->importLinkbase( $basePath, $import->value );
            }
            $namespace = $dom->getNamespace();
            $this->imports[$namespace] = $dom;
            $this->realPathToImport[$schemaLocation] = $namespace;
            return $dom;
        }
        return null;
    }

    /**
     * @param string $basePath
     * @param string $schemaLocation
     */
    protected function importLinkbase( $basePath, $schemaLocation )
    {
        $p = parse_url( $schemaLocation );
        if ( empty( $p['scheme'] ) ) {
            $schemaLocation = realpath( $basePath . '/' . $p['path'] );
            $this->linkbases[] = new LinkBase( $this, $schemaLocation );
        }
    }

    /**
     * @return Arc[]
     */
    public function getArcs()
    {
        $multiIterator = new \AppendIterator();
        foreach( $this->linkbases as $linkBase ) {
            $multiIterator->append( $linkBase->getIterator() );
        }
        return $multiIterator;
    }

    /**
     * @param Concept $concept
     * @return Arc[]
     */
    public function getArcsFromConcept( Concept $concept )
    {
        if ( is_null( $this->arcCache ) ) {
            $this->arcCache = array();
            foreach( $this->getArcs() as $arc )
            {
                /** @var $fromConcept NamespaceId */
                foreach( $arc->getFromConcepts() as $fromConcept )
                {
                    if ( !isset( $this->arcCache[$fromConcept->namespace] ) ) {
                        $this->arcCache[$fromConcept->namespace] = array();
                    }
                    if ( !isset( $this->arcCache[$fromConcept->namespace][$fromConcept->id] ) ) {
                        $this->arcCache[$fromConcept->namespace][$fromConcept->id] = array();
                    }
                    $this->arcCache[$fromConcept->namespace][$fromConcept->id][] = $arc;
                }
            }
        }
        $namespaceArcCache = $this->arcCache[$concept->getNamespace()];
        if ( $namespaceArcCache ) {
            return $namespaceArcCache[$concept->getId()];
        }
        return null;
    }

    /**
     *
     * @return Concept[]
     */
    public function getConcepts()
    {
        $multiIterator = new \AppendIterator();
        foreach( $this->imports as $import ) {
            $multiIterator->append( new \ArrayIterator( $import->getConcepts() ) );
        }
        return $multiIterator;
    }

    /**
     * @param NamespaceId $id
     * @return Concept|null
     */
    public function getConcept( NamespaceId $id )
    {
        if ( !empty( $this->imports[$id->namespace] ) ) {
            return $this->imports[$id->namespace]->getConceptById( $id->id );
        }
        return null;
    }
}