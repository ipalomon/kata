<?php
require_once "../src/autoload.php";

use Kata\App\ValidateJsonStructure;
use Kata\Infrastructure\Controllers\EvGridController;
use Kata\Infrastructure\Controllers\MoveController;
use Kata\Infrastructure\Factories\EvGridFactory;
use Kata\Infrastructure\Factories\MoveEvFactory;


$electricVehicles = (json_decode(file_get_contents("php://input"), true));

$validateJsonStructure = new ValidateJsonStructure($electricVehicles);
if($validateJsonStructure->validateStructure()){
    $limit = $electricVehicles["limit"];
    $positions = array();
    foreach ($electricVehicles["evs"] as $key => $electricVehicle){
        $positions[] = $electricVehicle["position"];
    }
    $outputGrid = EvGridFactory::build();
    $controllerGrid = new EvGridController($outputGrid);

    $evGrid = $controllerGrid($positions, $limit);

    foreach ($electricVehicles["evs"] as $key => $electricVehicle){
        $output = MoveEvFactory::build();

        $controller = new MoveController($output, $evGrid);
        $controller($electricVehicle["position"], $electricVehicle["explore_area"]);
    }
}
else{
    $httpResponse = array("code"=>"409", "message"=>"Invalid structure");
}



