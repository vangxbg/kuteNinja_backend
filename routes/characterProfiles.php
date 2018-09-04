<?php
/** This code handles the requests for chracter profile */

// URI: /api/v1/characterProfile/
// TYPE: POST
// Purpose: To update the user’s data when they go online.
// Payload: JSON string object that includes
//     {
//     type:*,
//     profile:{
//         u_id:*,
//     level:*,
//     exp:*
//     }
//     }
// Server Action: Insert new entry into Character profile if the profile does not exist. If it does, then update the current entry.
// Insert raw data into the Transaction Audit table.
// Return: string, profile unique id if new entry was created.
function CharProfile($conn){
    $postData = json_decode(file_get_contents('php://input'));
    $id = $postData->id;
    $level = $postData->level;
    $data = $postData->data;
    $result = $conn->query("SELECT * FROM characterprofile WHERE `id` = $id");
    if($result->num_rows > 0){
        // echo "found query ";
        // $conn->query("UPDATE `transactionaudit` SET `data` = $data WHERE `id` = $id");
        $conn->query("UPDATE `characterprofile` SET `level` = $level WHERE `id` = $id");
        $result = $conn->query("SELECT * FROM characterprofile WHERE `id` = $id");
        $outPut = $result->fetch_assoc();
        return json_encode($outPut);
    }else{
        // echo "no existed query so ";
        // $sql = "INSERT INTO transactionaudit (`data`) VALUES ($data)";
        $sql = "INSERT INTO characterprofile (`u_id`, `user_id`, `level`, `exp`) VALUES ('ajlksdfd', 1, $level, 1)";
        if (($result = $conn->query($sql)) === TRUE) {
            // echo "NEW record created successfully with id of: " . $conn->insert_id . " ";
            $result = $conn->query("SELECT * FROM characterprofile WHERE `id` = $conn->insert_id");
            $outPut = $result->fetch_assoc();
            return json_encode($outPut);
        }else{
            echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
        }
    }
}
