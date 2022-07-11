<?php

declare(strict_types = 1);

namespace Kata\Tests;

use Kata\App\ValidateJsonStructure;
use PHPUnit\Framework\TestCase;

final class KataTest extends TestCase
{
    const KEYS = array('limit', 'evs', "subways" => array("position", "explore_area"));
    /**
     * @test
     */
    public function itShouldInitialCase(): void
    {

        self::assertTrue(true);
    }

    /**
     * @test
     */
    public function testStructureDataIsValid(): void
    {
        $dummyStructureArray = $this->getDummyData();
        $expectedValue = false;
        $expectedValue = $this->isValidStructure($dummyStructureArray);
        self::assertTrue($expectedValue, "Ok This Json request is valid but espected true");
    }

    /**
     * @test
     */
    public function testStructureDataIsNotValid(): void
    {
        // Change key limit by PEPE
        $dummyStructureArray = json_decode('{
                "PEPE": "5 5",
                "evs": [
                    {
                        "position": "1 2 N",
                        "explore_area": "LMLMLMLMM"
                    },
                    {
                        "position": "3 3 E",
                        "explore_area": "MMRMMRMRRM"
                    }
                ]
            }', true);

        $expectedValue = false;
        $expectedValue = $this->isValidStructure($dummyStructureArray);
        self::assertFalse($expectedValue, "Ok This Json request is NOT valid but expected true");
    }

    public function getDummyData():array{
        return json_decode('{
                "limit": "5 5",
                "evs": [
                    {
                        "position": "1 2 N",
                        "explore_area": "LMLMLMLMM"
                    },
                    {
                        "position": "3 3 E",
                        "explore_area": "MMRMMRMRRM"
                    }
                ]
            }', true);
    }

    public function isValidStructure($dummyStructureArray):bool
    {
        $spectedValue = false;
        $keys = array_keys($dummyStructureArray);
        if($keys[0] === self::KEYS[0]){
            if($keys[1] === self::KEYS[1]){
                foreach ($dummyStructureArray["evs"] as  $ev){
                    $subways = array_keys($ev);
                    if(($subways[0] === self::KEYS["subways"][0]) && ($subways[1] === self::KEYS["subways"][1])){
                        $spectedValue = true;
                    }
                }
            }
        }
        return $spectedValue;
    }


}
