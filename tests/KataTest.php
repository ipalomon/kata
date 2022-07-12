<?php

declare(strict_types = 1);

namespace Kata\Tests;

use Kata\App\ValidateJsonStructure;
use Kata\Domain\Entities\Ev;
use Kata\Domain\Entities\EvGrid;
use Kata\Domain\ValueObjects\ExploreArea;
use Kata\Domain\ValueObjects\Position;
use PHPUnit\Framework\TestCase;

final class KataTest extends TestCase
{
    // Structure the response
    const KEYS = array('limit', 'evs', "subways" => array("position", "explore_area"));

    /**
     *
     * @test
     */
    public function itShouldInitialCase(): void
    {

        self::assertTrue(true);
    }

    /**
     * Validate structure the request
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
     * Invalid Structure request see the line 49 PEPE expected limit
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

    /**
     * Dummy data for test
     * @return array
     */
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

    /**
     * Check the structure request
     * @param $dummyStructureArray
     * @return bool
     */
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
    /**
     * Check the length the position
     * @test
     */
    // The value Object test
    public function testGetCoordinatesAndOrientation(): void
    {
        $position = "1 2 N";
        self::assertCount(3, explode(" ", $position));
    }

    /**
     * Check the correct position "x y cardinal point" and The cardinal point match be N, E, S or W
     * @test
     */
    public function testValidateCoordinatesAndOrientation(){
        $position = "1 2 N";
        $coordinatesXyOrientation = $this->getCoordinatesAndOrientation($position);
        $r = true;
        if(!ctype_digit((string) $coordinatesXyOrientation[0])){
            $r = false;
            self::assertFalse(false, "This no digit $coordinatesXyOrientation[0]");
        }
        if(!ctype_digit((string) $coordinatesXyOrientation[1])){
            $r = false;
            self::assertFalse(false, "This no digit $coordinatesXyOrientation[1]");
        }
        if(is_numeric( $coordinatesXyOrientation[2])){
            $r = false;
            self::assertFalse(false, "This is digit $coordinatesXyOrientation[2]");
        }else{
            if(!in_array($coordinatesXyOrientation[2], array("N", "S", "E", "W"), true)){
                $r = false;
                self::assertFalse(false, "Match be  N, S, E, W $coordinatesXyOrientation[2] ");
            }
        }

        self::assertTrue($r);
    }

    /**
     * Check the correct position NO VALID "x y cardinal point" and The cardinal point match be N, E, S or W
     * @test
     */
    public function testNOTValidateCoordinates(){
        $position = "1 f N";
        $coordinatesXyOrientation = $this->getCoordinatesAndOrientation($position);
        $r = true;
        if(!ctype_digit((string) $coordinatesXyOrientation[0])){
            $r = false;
            self::assertTrue(true, "This no digit $coordinatesXyOrientation[0]");
        }
        if(!ctype_digit((string) $coordinatesXyOrientation[1])){
            $r = false;
            self::assertTrue(true, "This no digit $coordinatesXyOrientation[1]");
        }
        self::assertFalse($r );
    }

    /**
     * Check the Not Valid cardinal point
     * @test
     */
    public function testNOTValidateOrientation(){
        $position = "1 2 NN";
        $coordinatesXyOrientation = $this->getCoordinatesAndOrientation($position);
        $r = true;
        if(is_numeric( $coordinatesXyOrientation[2])){
            $r = false;
            self::assertTrue(true, "This is digit $coordinatesXyOrientation[2]");
        }else{
            if(!in_array($coordinatesXyOrientation[2], array("N", "S", "E", "W"), true)){
                $r = false;
                self::assertTrue(true, "Match be  N, S, E, W $coordinatesXyOrientation[2]");
            }
        }
        self::assertFalse($r);
    }
    public function getCoordinatesAndOrientation($position): array
    {
        return explode(" ", $position);
    }

    /**
     * Set the new position
     * @test
     */
    public function testSetNewPosition(){

        $exploreArea = new ExploreArea("MMRMMRMRRM");
        $position = new Position("3 3 E");
        $ev = new Ev($position, $exploreArea);
        $exploreAreaPerUnits = str_split("MMRMMRMRRM");
        $evGrid = new EvGrid((array)$position, "5 5");
        $coordinatesXY = str_split(str_replace(" ","","5 5"));
        $limitX = $coordinatesXY[0];
        $limitY = $coordinatesXY[1];
        $coordinatesXyOrientation = $position->getCoordinatesAndOrientation($position);
        foreach ($exploreAreaPerUnits as $exploreAreaPerUnit){
            $x = $coordinatesXyOrientation[0];
            $y = $coordinatesXyOrientation[1];
            $orientation = $coordinatesXyOrientation[2];
            if($exploreAreaPerUnit == "M"){
                if($orientation == "N"){
                    $coordinatesXyOrientation[1]++;
                }elseif($orientation == "E"){
                    $coordinatesXyOrientation[0]++;
                }elseif($orientation == "S"){
                    $coordinatesXyOrientation[1]--;
                }elseif($orientation == "W"){
                    $coordinatesXyOrientation[0]--;
                }
            }elseif ($exploreAreaPerUnit == "L"){
                if($orientation == "N"){
                    $coordinatesXyOrientation[2] = "W";
                }elseif($orientation == "E"){
                    $coordinatesXyOrientation[2] = "N";
                }elseif($orientation == "S"){
                    $coordinatesXyOrientation[2] = "E";
                }elseif($orientation == "W"){
                    $coordinatesXyOrientation[2] = "S";
                }
            }elseif ($exploreAreaPerUnit == "R") {
                if ($orientation == "N") {
                    $coordinatesXyOrientation[2] = "E";
                } elseif ($orientation == "E") {
                    $coordinatesXyOrientation[2] = "S";
                } elseif ($orientation == "S") {
                    $coordinatesXyOrientation[2] = "W";
                } elseif ($orientation == "W") {
                    $coordinatesXyOrientation[2] = "N";
                }
            }
        }
        self::assertEquals("5 1 E", $coordinatesXyOrientation[0]." ".$coordinatesXyOrientation[1]." ".$coordinatesXyOrientation[2]);

        $newPosition = new Position($coordinatesXyOrientation[0]." ".$coordinatesXyOrientation[1]." ".$coordinatesXyOrientation[2]);
        $ev->setPosition($newPosition);
        $evGrid->setPosition($ev->getPosition());
        //echo $coordinatesXyOrientation[0]." ".$coordinatesXyOrientation[1]." ".$coordinatesXyOrientation[2];
    }

    /**
     * Check the collides ev into the Grid
     * @test
     */
    public function testCheckCollidesEv(){
        // TODO implemented in MoveService.php line 116
    }

    /**
     * Check the limit Grid when the ev is move.
     * @test
     */
    public function testCheckCoordinatesLimit(){
        // TODO implemented in MoveService.php line 108
    }

}
