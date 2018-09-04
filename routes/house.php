<?php
/** This code handles the request for house uri */

// ::4
// URI: /api/v1/house/
// TYPE: POST
// Purpose: To update the house data.
// Payload: JSON string object that includes
// 	{
//     type:*,
// 		u_id:*,
//     house:{
//   		u_id:*,
//       name:*,
//       description:*,
//       min_level:*,
//       cost_coin:*,
//       cost_ruby:*
//     }
// 	}
// Server Action: Insert new entry into House Table if house does not exist. If it does, then update the current entry.
// Verify that the user exist before interaction with the database. If payload of house->u_id is null, then check if user can add a new house profile to the house table.
// Insert raw data into the Transaction Audit table.
// Return: string, house unique id if new entry was created.
function House($conn){
    $postData = json_decode(file_get_contents('php://input'));
    $id = $postData->id;
    $cost_coin = $postData->cost_coin;
    $cost_ruby = $postData->cost_ruby;
    $name = $postData->name;
    $description = $postData->description;
    $result = $conn->query("SELECT * FROM housetable WHERE `id` = $id");
    if($result->num_rows > 0){
        echo "found query ";
        $conn->query("UPDATE `housetable` SET `cost_coin` = $cost_coin, cost_ruby = $cost_ruby WHERE `id` = $id");
        $result = $conn->query("SELECT * FROM housetable WHERE `id` = $id");
        $outPut = $result->fetch_assoc();
        return json_encode($outPut);
    }else{
        echo "no existed query so ";
        $sql = "INSERT INTO housetable (`cost_coin`, `cost_ruby`, `user_id`, `name`, `description`) VALUES ($cost_coin, $cost_ruby, 111, $name, $description)";
        if (($result = $conn->query($sql)) === TRUE) {
            echo "NEW record created successfully with id of: " . $conn->insert_id . " ";
            $result = $conn->query("SELECT * FROM housetable WHERE `id` = $conn->insert_id");
            $outPut = $result->fetch_assoc();
            return json_encode($outPut);
        }else{
            echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
        }
    }
}