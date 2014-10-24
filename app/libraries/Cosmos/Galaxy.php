<?php namespace Cosmos;

/**
 * Galaxy
 *
 * Class for all galaxy objects
 *
 * @author jacobbridges
 */


class Galaxy extends CosmosBase {

    /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
     *                    S T A T I C   A T T R I B U T E S                    *
     * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

    // The cosmos view layer
    static public $layer = 1;

    // Redis hash for Multiverse galaxies
    static private $galaxyHash = 'cosmos:galaxies';

    // Redis hash for Multiverse galaxy names
    static private $galaxyNamesHash = 'cosmos:msnames';

    // Prefix for assigning IDs to galaxies
    static private $prefix = 'galaxy';


    /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
     *                           A T T R I B U T E S                           *
     * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

    // Number of child solar systems for this galaxies
    private $numSolarSystems = 0;

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
     * Galaxy constructor
     */
    public function __construct( $universeID )
    {
        // Set the galaxy's redis list
        $this->setRedisList($universeID);

        // Generate default name and ID for the galaxy
        parent::__construct(
            $this->generateID(self::$prefix),
            $this->generateName(self::$galaxyNamesHash)
        );

        // Attempt to save the galaxy to the database
        $attempts = 1;
        while ($this->save(self::$galaxyHash, $this->getRedisList()) == false && $attempts <= 5)
        {
            parent::__construct(
                $this->generateID(self::$prefix),
                $this->generateName(self::$galaxyNamesHash)
            );

            // Keep track of any failed attempts to save the universe
            $attempts++;
        }
    }

    /*
     * Galaxy destructor
     */
    function __destruct()
    {
        echo "<br> Destroying " . $this->getMultiverseID();
        $redis = \Redis::connection();
        $redis->hdel(self::$galaxyHash, $this->getMultiverseID());
    }

    /*
     * Get the number of child solar systems
     */
    public function getNumSolarSystems()
    {
        return $this->numSolarSystems;
    }

    /*
     * Set the number of child solar systems
     */
    public function setNumSolarSystems($numSolarSystems)
    {
        $this->numSolarSystems = $numSolarSystems;
    }

    /*
     * Get the number of child (direct) starts
     */
    public function getNumStars()
    {
        return $this->numStars;
    }

    /*
     * Set the number of child (direct) starts
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