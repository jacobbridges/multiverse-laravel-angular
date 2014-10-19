<?php namespace Cosmos;

/**
 * CosmosBase
 * 
 * Base class for all cosmos objects. 
 *
 * @author jacobbridges
 */
class CosmosBase {
    
    /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
     *                    S T A T I C   A T T R I B U T E S                    *
     * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
    
    // The cosmos view layer
    static $layer = 0;
    
    
    /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
     *                           A T T R I B U T E S                           *
     * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
    
    // ID of the object assigned by the galactic database
    private $ID = '';
    
    // Default name assigned to undiscovered object
    private $name = '';
    
    // Name given to a discovered object
    public $alias = '';
    
    
    /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
     *                              M E T H O D S                              *
     * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
    
    // CosmosBase constructor
    function __construct( $dbID, $dbName )
    {
        $this->setMultiverseID( $dbID );
        $this->setMultiverseName( $dbName );
    }
    
    // CosmosBase destructor
    function __destruct()
    {
        echo "<br> Destroying " . $this->name;
    }
    
    // Get the cosmos view layer
    public function getCosmosLayer()
    {
        return self::$layer;
    }
    
    // Get the Multiverse database id
    public function getMultiverseID()
    {
        return $this->ID;
    }
    
    // Get the Multiverse database name
    public function getMultiverseName()
    {
        return $this->name;
    }
    
    // Get the alias
    public function getAlias()
    {
        return $this->alias;
    }
    
    // Set the Multiverse database id
    private function setMultiverseID( $newID )
    {
        $this->ID = $newID;
    }
    
    // Set the Multiverse database name
    private function setMultiverseName( $newName )
    {
        $this->name = $newName;
    }
    
    // Set the alias
    public function setAlias( $newAlias )
    {
        $this->alias = $newAlias;
    }
    
    // Generate an ID which complies to the "Multiverse Standard"
    protected function generateID()
    {
        return get_class($this) . (string)(mt_rand(1000, 9999));
    }
    
    // Retrieve a name from the Redis database of standard names
    protected function generateName( $hash )
    {
        $redis = \Redis::connection();
        return  $redis->srandmember($hash);
    }
    
    // Save this universe to the database
    public function save( $hash )
    {
        $redis = \Redis::connection();
        return $redis->hsetnx($hash, $this->getMultiverseID(), $this->getMultiverseName());
    }
    
}

?>
