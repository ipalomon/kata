<?php

namespace Kata\App;

class ValidateJsonStructure
{

    private $jsonStructure;
    private const KEYS = array('limit', 'evs', "subways" => array("position", "explore_area"));

    /**
     * @param array $jsonStructure
     */
    public function __construct(array $jsonStructure)
    {
        $this->jsonStructure = $jsonStructure;
    }

    public function validateStructure() : bool
    {
       // foreach ($this->jsonStructure as $limit => $value){}
        $keys = array_keys($this->jsonStructure);
            if($keys[0] === self::KEYS[0]){
                if($keys[1] === self::KEYS[1]){
                    foreach ($this->jsonStructure["evs"] as  $ev){
                        $subways = array_keys($ev);
                        if(($subways[0] === self::KEYS["subways"][0]) && ($subways[1] === self::KEYS["subways"][1])){
                            return true;
                        }
                    }
                }
            }
        return false;
    }

}