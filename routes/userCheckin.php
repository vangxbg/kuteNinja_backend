<?php
/** This code handles the request for user checkin uri */

// URI: /api/v1/user/checkin
// TYPE: POST
// Purpose: To update the user’s data when they go online.
// Payload: JSON string object that includes
// {
//     type:*,
//     u_id:*
// }
// Server Action:
// Insert new entry into User Check In table
// Insert raw data into the Transaction Audit table.
// Return: bool, empty
function UserCheckin($conn){
    $postData = json_decode(file_get_contents('php://input'));
    $id = $postData->id;
    $ip = $postData->ip;
    // echo gettype($id);
    $result = $conn->query("SELECT * FROM usercheckin WHERE `id` = $id");
    if($result->num_rows > 0){
        echo "found query ";
        $conn->query("UPDATE `usercheckin` SET `ip` = $ip WHERE `id` = $id");
        $result = $conn->query("SELECT * FROM usercheckin WHERE `id` = $id");
        $outPut = $result->fetch_assoc();
        return json_encode($outPut);
    }else{
        echo "no existed query so ";
        $sql = "INSERT INTO usercheckin (`ip`) VALUES ($ip)";
        if (($result = $conn->query($sql)) === TRUE) {
            echo "NEW record created successfully with id of: " . $conn->insert_id . " ";
            $result = $conn->query("SELECT * FROM usercheckin WHERE `id` = $conn->insert_id");
            $outPut = $result->fetch_assoc();
            return json_encode($outPut);
        }else{
            echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
        }
    }
}
