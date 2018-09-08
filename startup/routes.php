<?php
/** The code here listens to the request on the server and routes it to a handler */

// load the required php files here
require('./routes/characterProfiles.php');
require('./routes/heartBeat.php');
require('./routes/userCheckin.php');
require('./routes/house.php');

// handle the GET requests
if( strtolower($request) == "get"){
    switch ( $uri ){
        case "/api/v1/heartbeat": 
            echo "getting on /api/v1/heartbeat ";
            echo HeartBeat(); 
            break;
        default: break;
    }
// handle the POST requests
}else{
    switch ( $uri ){
        case "/api/v1/characterprofile": 
            echo "posting on /api/v1/characterprofile ";
            echo CharProfile($conn); 
            break;
        case "/api/v1/user/checkin":
            echo "posting on /api/v1/user/checkin ";
            echo UserCheckin($conn);
            break;
        case "/api/v1/house":
            echo "posting on /api/v1/house ";
            echo House($conn);
        default: break;
    }
}