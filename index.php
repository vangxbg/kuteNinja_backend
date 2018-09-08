<?php
/** This code is the main file that is run */

// load the required headers here
// header('Content-Type: application?/json'); // allows chrome to make the json readable

// open server listening to the uri requests
$request = $_SERVER['REQUEST_METHOD']; // get the server request method
$uri = $_SERVER['REQUEST_URI']; // get the uri of the server request
if( $uri[0] == "/") $uri = substr($uri, 1); // remove the first / from the uri
if( $uri[strlen($uri) - 1] == "/") $uri = substr($uri, 0, strlen($uri) -1); // remove the last / from the uri
$uri = strtolower($uri);
$uri = str_replace("kuteninja","",$uri); // remove kuteNinja from the uri

// load the required php files here
require('./startup/db.php');  // loading the database
require('./startup/routes.php'); // routing all the requests to a handler

