<?php

namespace Kata\Application\Services;

use Kata\Domain\Entities\Ev;
use Kata\Domain\Entities\EvGrid;
use Kata\Domain\Interfaces\EvInterface;
use Kata\Domain\ValueObjects\ExploreArea;
use Kata\Domain\ValueObjects\Position;

/**
 * This service move the Ev and update the Grid Ev´s positions
 */
class MoveService
{
    private EvInterface $output;
    private EvGrid $evGrid;

    /**
     * Inject dependencies
     * @param EvInterface $output
     * @param EvGrid $evGrid
     */
    function __construct(EvInterface $output, EvGrid $evGrid)
    {
        $this->output = $output;
        $this->evGrid = $evGrid;
    }

    /**
     * @param Position $position
     * @param ExploreArea $exploreArea
     * @return void
     */
    public function __invoke(Position $position, ExploreArea $exploreArea): array
    {
        // Build The current Ev Object
        $ev = new Ev(
            new Position($position),
            new ExploreArea($exploreArea)
        );
        // Validate params;
        if(!$position->validateCoordinatesAndOrientation($position)){
            return array("code"=>"409","message"=>"Invalid position ".$position);
        }
        if(!$exploreArea->validateExploreArea($position)){
            return array("code"=>"409","message"=>"Invalid explorer area  ".$exploreArea);
        }
        // Give the positions into the Gird and limit the Gird.

        $limit = $this->evGrid->getLimitXY();

        $newPositionResponse = $this->moveEv($position, $exploreArea, $limit, $ev);

        // Save via doctrine entityManager
        $this->output->save($ev);

        return $newPositionResponse;
    }

    /**
     * @param Position $position
     * @param ExploreArea $exploreArea
     * @param string $limit
     * @param Ev $ev
     * @return string[]
     */
    private function moveEv(Position $position, ExploreArea $exploreArea, string $limit, Ev $ev):array{
        $exploreAreaPerUnits = str_split($exploreArea);
        $coordinatesXY = str_split(str_replace(" ","",$limit));
        $limitX = $coordinatesXY[0];
        $limitY = $coordinatesXY[1];

        $coordinatesXyOrientation = $position->getCoordinatesAndOrientation($position);
        foreach ($exploreAreaPerUnits as $exploreAreaPerUnit){
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
            // Check limit for each the new position Ev
            if($coordinatesXyOrientation[0] > $limitX || $coordinatesXyOrientation[0] < 0){
                return array("code"=>"409","message"=>"Invalid position. X Out of Grid  ".$coordinatesXyOrientation[0]);
            }
            if($coordinatesXyOrientation[1] > $limitY || $coordinatesXyOrientation[1] < 0){
                return array("code"=>"409","message"=>"Invalid position. Y Out of Grid  ".$coordinatesXyOrientation[1]);
            }

            // Check collides witch other position this Ev into de Grid
            $positions = $this->evGrid->getPositions();
            if(in_array($coordinatesXyOrientation[0]." ".$coordinatesXyOrientation[1]." ".$coordinatesXyOrientation[2], $positions)){
                return array("code"=>"409","message"=>"Invalid position. collides with another grid position  ".$coordinatesXyOrientation[0]." ".$coordinatesXyOrientation[1]." ".$coordinatesXyOrientation[2]);
            }
        }
        // Delete old position in the Grid
        $positions = $this->evGrid->getPositions();
        $oldPosition[] = $ev->getPosition();
        $positions = array_diff($positions, $oldPosition);
        // Set new position in the grid
        $positions[] = $coordinatesXyOrientation[0]." ".$coordinatesXyOrientation[1]." ".$coordinatesXyOrientation[2];
        $this->evGrid->setPositions($positions);

        $newPosition = new Position($coordinatesXyOrientation[0]." ".$coordinatesXyOrientation[1]." ".$coordinatesXyOrientation[2]);
        $ev->setPosition($newPosition);
        $this->evGrid->setPosition($ev->getPosition());
        return array("code"=> "200", "message"=>"New position has be change correctly ".$coordinatesXyOrientation[0]." ".$coordinatesXyOrientation[1]." ".$coordinatesXyOrientation[2]);
    }
}