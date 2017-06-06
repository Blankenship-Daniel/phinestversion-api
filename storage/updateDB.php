#!/usr/bin/php
<?php
$db = new PDO('sqlite:/home2/theblas4/laravel-pv-api/storage/database.sqlite');
$db->setAttribute(PDO::ATTR_ERRMODE, 
                  PDO::ERRMODE_EXCEPTION);

function updateDB($db) 
{
    echo "UPDATE shows\n";
    updateShows($db);
    echo "UPDATE songs\n";
    updateSongs($db);
    echo "UPDATE venues\n";
    updateVenues($db);
}

function updateShows($db)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'http://phish.in/api/v1/shows.json?per_page=3&page=1&sort_attr=date&sort_dir=desc');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($ch);

    $json = json_decode($output);
   
    foreach ($json->data as $d) {
        $stmt = $db->prepare("INSERT OR IGNORE INTO shows (id, date, tour_id, venue_id) VALUES (:id, :date, :tour_id, :venue_id)");
        $stmt->bindParam(':id', $d->id);
        $stmt->bindParam(':date', $d->date);
        $stmt->bindParam(':tour_id', $d->tour_id);
        $stmt->bindParam(':venue_id', $d->venue_id);
        $stmt->execute();
    }
 
    curl_close($ch);  
}

function updateSongs($db) 
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'http://phish.in/api/v1/songs.json?sort_attr=id&sort_dir=desc&per_page=50');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($ch);

    $json = json_decode($output);
   
    foreach ($json->data as $d) {
        $stmt = $db->prepare("INSERT OR IGNORE INTO songs (id, title, tracks_count, slug) VALUES (:id, :title, :tracks_count, :slug)");
        $stmt->bindParam(':id', $d->id);
        $stmt->bindParam(':title', $d->title);
        $stmt->bindParam(':tracks_count', $d->tracks_count);
        $stmt->bindParam(':slug', $d->slug);
        $stmt->execute();
    }
 
    curl_close($ch);  
}

function updateVenues($db) 
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'http://phish.in/api/v1/venues.json?sort_attr=id&sort_dir=desc&page=1&per_page=3');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($ch);

    $json = json_decode($output);
   
    foreach ($json->data as $d) {
        $stmt = $db->prepare("INSERT OR IGNORE INTO venues (id, name, shows_count, location, slug) VALUES (:id, :name, :shows_count, :location, :slug)");
        $stmt->bindParam(':id', $d->id);
        $stmt->bindParam(':name', $d->name);
        $stmt->bindParam(':shows_count', $d->shows_count);
        $stmt->bindParam(':location', $d->location);
        $stmt->bindParam(':slug', $d->slug);
        $stmt->execute();
    }
 
    curl_close($ch);    
}

try {
    updateDB($db);
    echo 'successful update' . "\n";
}
catch (PDOException $e) {
    echo $e->getMessage();
}

$db = null;
?>
