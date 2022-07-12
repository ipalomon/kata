<?php
require_once "../src/autoload.php";

use Kata\App\ValidateJsonStructure;
use Kata\Domain\ValueObjects\ExploreArea;
use Kata\Domain\ValueObjects\Position;
use Kata\Infrastructure\Controllers\EvGridController;
use Kata\Infrastructure\Controllers\MoveController;
use Kata\Infrastructure\Factories\EvGridFactory;
use Kata\Infrastructure\Factories\MoveEvFactory;


$electricVehicles = (json_decode(file_get_contents("php://input"), true));

// Validate structure of the request
$validateJsonStructure = new ValidateJsonStructure($electricVehicles);
if($validateJsonStructure->validateStructure()){
    $limit = $electricVehicles["limit"];
    $positions = array();

    // Load the positions of the Request
    foreach ($electricVehicles["evs"] as $key => $electricVehicle){
        $positions[] = $electricVehicle["position"];
    }

    // Build the Grid witch the Ev
    $outputGrid = EvGridFactory::build();
    $controllerGrid = new EvGridController($outputGrid);
    $evGrid = $controllerGrid($positions, $limit);

    // Parse the request Ev by Ev position
    foreach ($electricVehicles["evs"] as $key => $electricVehicle){
        // Build the Ev
        $output = MoveEvFactory::build();
        // Move the Ev based in explore area
        $controller = new MoveController($output, $evGrid);
        $httpResponse = $controller(new Position($electricVehicle["position"]), new ExploreArea($electricVehicle["explore_area"]));
    }
}else{
    $httpResponse = array("code"=>"409", "message"=>"Invalid structure");
}

// Only use for test Swagger or Postman.
echo $httpResponse;


