<?php
/** This handles the requests for heatbeat uri */

// payload class for storing the heartbeat information
class Payload{};

// URI: /api/v1/heartBeat
// Type: GET
// Purpose: To check the status of the server
// Payload: None
// Server Action: Get Current Date Time
// Return: string, Current Date Time in Seconds since epoch form.
function HeartBeat(){
    $test = new Payload();
    $test->status = 400;
    $test->data = time();
    return json_encode($test);
}