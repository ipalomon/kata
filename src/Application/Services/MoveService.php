<?php

namespace Kata\Application\Services;

use Kata\Domain\Entities\Ev;
use Kata\Domain\Entities\EvGrid;
use Kata\Domain\Interfaces\EvInterface;
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
     * @param string $position
     * @param string $exploreArea
     * @return void
     */
    public function __invoke(string $position, string $exploreArea): void
    {

        // Build de Ev Object
        $ev = new Ev($position, $exploreArea);

        $positions = $this->evGrid->getPositions();
        $limit = $this->evGrid->getLimitXY();

        if(in_array($position,$positions)){
            throw new RuntimeException('This position is busy into Grid');
        }
        // Save via doctrine entityManager
        $this->output->save($ev);
    }

}