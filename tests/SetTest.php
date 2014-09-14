<?php
use adrianclay\xbrl\Taxonomy\Concept;
use adrianclay\xbrl\Taxonomy\NamespaceId;
use adrianclay\xbrl\Taxonomy\Set;

class SetTest extends PHPUnit_Framework_TestCase
{
    /**
     * @return Set
     */
    private function getSet()
    {
        $set = new Set();
        $set->import( __DIR__ . '/ca-gaap-pfs-2007-01-19/', 'ca-gaap-pfs-2007-01-19.xsd' );
        return $set;
    }

    public function testGetConcept()
    {
        $namespace = 'http://www.xbrl.org/ca/fr/gaap/pfs/ca-gaap-pfs-2007-01-19';
        $concept = $this->getSet()->getConcept( new NamespaceId( $namespace, 'ca-gaap-pfs_Land' ) );
        $this->assertNotEmpty( $concept );
        $this->assertEquals( 'Land', $concept->getName() );
        $this->assertEquals( $namespace, $concept->getNamespace() );
        $this->assertEquals( 'debit', $concept->getBalance() );
        $this->assertEquals( 'instant', $concept->getPeriodType() );
        $type = $concept->getType();
        $this->assertEquals( 'monetaryItemType', $type->getName() );
        $substitutionGroup =  $concept->getSubstitutionGroup();
        $this->assertEquals( 'item', $substitutionGroup->getName() );
        return $concept;
    }

    /**
     * @depends testGetConcept
     */
    public function testGetArcsFromConcept( Concept $concept )
    {
        $arcs = $this->getSet()->getArcsFromConcept( $concept );
        $this->assertCount( 2, $arcs );
    }


    public function testGetConcepts()
    {
        $this->assertCount( 612, $this->getSet()->getConcepts() );
    }

}
