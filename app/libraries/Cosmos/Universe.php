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
    
    // Prefix for assigning IDs to universes
    static private $prefix = 'universe';
    
    // This univers's galaxies
    static private $galaxies = [];
    
    
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
    private $redisList = '';
    
    
    
    /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
     *                              M E T H O D S                              *
     * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
    
    /*
     * Universe constructor
     */
    public function __construct( )
    {
        // Generate default name and ID for the Universe
        parent::__construct(
            $this->generateID(self::$prefix), 
            $this->generateName(self::$universeNamesHash)
        );
        
        // Attempt to save the universe to the database
        $attempts = 1;
        while ($this->save(self::$universeHash) == false && $attempts <= 5)
        {
            parent::__construct(
                $this->generateID(self::$prefix), 
                $this->generateName(self::$universeNamesHash)
            );
            
            // Keep track of any failed attempts to save the universe
            $attempts++;
        }
    }
    
    /*
     * Universe destructor
     */
    function __destruct()
    {
        echo "<br> Destroying " . $this->getMultiverseID();
        $redis = \Redis::connection();
        $redis->hdel(self::$universeHash, $this->getMultiverseID());
    }
    
    /*
     * Generate a child galaxy
     */
    public function generateGalaxy()
    {
        $this->numGalaxies++;
        $new_galaxy = new \Cosmos\Galaxy( $this->getMultiverseID() );
        array_push( $this::$galaxies, $new_galaxy);
    }
    
    /*
     * Get child galaxies
     */
    public function getGalaxies()
    {
        //$redis = \Redis::connection();
        //return $redis->smembers($this->getMultiverseID());
        return $this::$galaxies;
    }

    /*
     * Get the number of child galaxies
     */
    public function getNumGalaxies()
    {
        return $this->numGalaxies;
    }

    /*
     * Set the number of child galaxies
     */
    public function setNumGalaxies($numGalaxies)
    {
        $this->numGalaxies = $numGalaxies;
    }

    /*
     * Get the number of child (direct) stars
     */
    public function getNumStars()
    {
        return $this->numStars;
    }

    /*
     * Set the number of child (direct) stars
     */
    public function setNumStars($numStars)
    {
        $this->numStars = $numStars;
    }

    /*
     * Get the redis list for this object
     */
    public function getRedisList()
    {
        return $this->redisList;
    }

    /*
     * Set the redis list for this object
     */
    public function setRedisList( $redisList )
    {
        $this->$redisList = $redisList;
    }
}