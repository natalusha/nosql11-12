<?php 
    require "vendor/autoload.php";

    $client = (new MongoDB\Client("mongodb://localhost:27017,mongodb://localhost:27018,mongodb://localhost:27019", , ["replicaSet" => ["db1", "db2", "db3"]]))->mongo;