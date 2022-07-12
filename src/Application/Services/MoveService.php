<?php

namespace Kata\Application\Services;

use Kata\Domain\Entities\Ev;
use Kata\Domain\Entities\EvGrid;
use Kata\Domain\Interfaces\EvInterface;
use Kata\Domain\ValueObjects\ExploreArea;
use Kata\Domain\ValueObjects\Position;
use RuntimeException;

class MoveService
{
    private $output;
    private $evGrid;

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
        $positions = $this->evGrid->getPositions();
        $limit = $this->evGrid->getLimitXY();

        $newPositionResponse = $this->moveEv($position, $exploreArea, $limit, $ev);

        echo $limit;
        print_r($positions);
        echo $position;
        echo $exploreArea;
        // Save via doctrine entityManager
        $this->output->save($ev);
    }

    private function moveEv(Position $position, ExploreArea $exploreArea, string $limit, Ev $ev):Ev{
        $exploreAreaPerUnits = str_split($exploreArea);
        $coordinatesXY = str_split(str_replace(" ","",$limit));
        $limitX = $coordinatesXY[0];
        $limitY = $coordinatesXY[1];
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
            echo $coordinatesXyOrientation[0]." ".$coordinatesXyOrientation[1]." ".$coordinatesXyOrientation[2]."\n";

        }
        $newPosition = new Position($coordinatesXyOrientation[0]." ".$coordinatesXyOrientation[1]." ".$coordinatesXyOrientation[2]);
        $ev->setPosition($newPosition);
        $this->evGrid->setPosition($ev->getPosition());
      return $ev;
    }

}