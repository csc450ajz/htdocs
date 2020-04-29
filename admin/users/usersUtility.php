<?php
include('../../util/db-config.php');


if (isset($_POST['userActions'])) {
    $actions = $_POST['userActions'];

    switch ($actions) {
        case 'getUsers':

            $output = '';
            $counter = 1;
            $usersResult = getUsers($conn);
            while ($thisRow = mysqli_fetch_assoc($usersResult)) {

                $output .= '  
                <tr>  
                <td>' . $counter . '</td>
                <td>' . $thisRow["userFName"] . ' ' . $thisRow["userLName"] . '</td>
                <td id="email">' . $thisRow["userEmail"] . '</td>
                <td id="type">' . $thisRow["userType"] . '</td>
                <td id="password">' . $thisRow["userPassword"] . '</td>
                <td><button type="button" name="edit" id="' . $thisRow["userEmail"] . '" class="btn btn-warning btn-xs edit"><i class="fas fa-user-edit"></i></button></td>
                <td><button type="button" name="delete" id="' . $thisRow["userEmail"] . '" class="btn btn-danger btn-xs delete"><i class="fas fa-trash"></i></button></td>
                <td id="FName" style="display:none;">' . $thisRow["userFName"] . '</td>
                <td id="LName" style="display:none;">' . $thisRow["userLName"] . '</td>
                </tr>
        
                ';
                $counter += 1;
            }

            echo $output;
            break;

        case 'getUser':

            $output = [];
            $userEmail = $_POST['userEmail'];
            $usersResult = getUserDetail($conn, $userEmail);
            while ($thisRow = mysqli_fetch_assoc($usersResult)) {

                $output['userEmail'] = $thisRow['userEmail'];
                $output['userFName'] = $thisRow['userFName'];
                $output['userLName'] = $thisRow['userLName'];
                $output['userType'] = $thisRow['userType'];
                $output['userPassword'] = $thisRow['userPassword'];
            }
            // echo $output;
            echo json_encode($output);
            break;

        case 'new':
            $result = createUser($conn, $_POST['userEmail'], $_POST['userFName'], $_POST['userLName'], $_POST['userType'], $_POST['userPassword']);
            if ($result) {
                echo ("Created New User");
            }
            break;

        case 'update':
            $result = updateUser($conn, $_POST['userEmail'], $_POST['userFName'], $_POST['userLName'], $_POST['userType'], $_POST['userPassword']);
            if ($result) {
                echo ("Update User");
            }
            break;

        case 'delete':
            $result = deleteUser($conn, $_POST['userEmail']);
            if ($result) {
                echo ("Deleted User");
            }
            break;

        default:
            break;
    }
}

function getUsers($conn)
{
    $sql = "SELECT * FROM User";
    $result = $conn->query($sql);
    $conn->next_result();
    echo $conn->error;
    return $result;
}

function getUserDetail($conn, $userEmail)
{
    $sql = "SELECT * FROM User WHERE userEmail='$userEmail'";
    $result = $conn->query($sql);
    $conn->next_result();
    echo $conn->error;
    return $result;
}


function createUser($conn, $userEmail, $userFName, $userLName, $userType, $userPassword)
{
    $sql = "INSERT INTO User (userEmail, userFName, userLName, userType, userPassword, userBalance) VALUES ('$userEmail', '$userFName','$userLName', '$userType', '$userPassword', 0)";
    $result = $conn->query($sql);
    $conn->next_result();
    echo $conn->error;
    return $result;
}

function updateUser($conn, $userEmail, $userFName, $userLName, $userType, $userPassword)
{
    $sql = "UPDATE User SET userFName='$userFName', userLName='$userLName', userType='$userType', userPassword='$userPassword' WHERE userEmail= '$userEmail'";
    $result = $conn->query($sql);
    $conn->next_result();
    echo $conn->error;
    return $result;
}

function deleteUser($conn, $userEmail)
{
    $sql = "DELETE FROM User WHERE userEmail='$userEmail'";
    $result = $conn->query($sql);
    $conn->next_result();
    echo $conn->error;
    return $result;
}
