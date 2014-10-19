<?php namespace Cosmos;

/**
 * Universe
 * 
 * Class for all universe objects.
 *
 * @author jacobbridges
 */
class Universe extends CosmosBase {
    
    /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
     *                    S T A T I C   A T T R I B U T E S                    *
     * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
    
    // The cosmos view layer
    static public $layer = 0;
    
    // Redis hash for Multiverse universes
    static private $universeHash = 'cosmos:universes';
    
    // Redis hash for Multiverse universe names
    static private $universeNamesHash = 'cosmos:msnames';
    
    
    /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
     *                           A T T R I B U T E S                           *
     * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
    
    // Number of child galaxies for this universe
    private $numGalaxies = 0;
    
    // Number of (direct) child stars
    private $numStars = 0;
    
    // Number of (direct) child novas
    private $numNovas = 0;
    
    // Number of (direct) child black holes
    private $numBlackHoles = 0;
    
    // Redis hash for universe
    private $dataHash = '';
    
    
    
    /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
     *                              M E T H O D S                              *
     * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
    
    // Universe contructor
    public function __construct( )
    {
        // Generate default name and ID for the Universe
        parent::__construct($this->generateID(), $this->generateName(self::$universeNamesHash));
        
        // Attempt to save the universe to the database
        $attempts = 0;
        while ($this->save(self::$universeHash) == false && $attempts < 5)
        {
            parent::__construct($this->generateID(), $this->generateName(self::$universeNamesHash));
            $attempts++;
        }
        
        self::$layer = 0;
    }
    
    // Universe destructor
    function __destruct()
    {
        echo "<br> Destroying " . $this->getMultiverseName();
        $redis = \Redis::connection();
        $redis->hdel(self::$universeHash, $this->getMultiverseID());
    }
    
    
}

?>