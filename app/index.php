<?php
require_once "../src/autoload.php";

use Kata\App\ValidateJsonStructure;
use Kata\Infrastructure\Controllers\OutputController;
use Kata\Infrastructure\Factories\OutputFactory;


//$electricVehicles = (json_decode(file_get_contents("php://input"), true));
$electricVehicles= json_decode('{
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
}',true);
$validateJsonStructure = new ValidateJsonStructure($electricVehicles);
if($validateJsonStructure->validateStructure()){
    $limit = $electricVehicles["limit"];
    foreach ($electricVehicles["evs"] as $key => $electricVehicle){
        $output = OutputFactory::build();
        $controller = new OutputController($output);
        $controller($electricVehicle["position"], $electricVehicle["explore_area"], $limit);
    }
}
else{
    $httpResponse = array("code"=>"409", "message"=>"Invalid structure");
}



