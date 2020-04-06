<?php
include('../../util/db-config.php');


if (isset($_POST['categoryActions'])) {
    $actions = $_POST['categoryActions'];

    switch ($actions) {
        case 'getCategories':

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
                <td><input type="button" name="view" value="view" class="view btn btn-primary btn-sm" id="' . $thisRow["userId"] . '" /></td>
                <td><button type="button" name="delete" id="' . $thisRow["userId"] . '" class="btn btn-danger btn-xs delete"><i class="fas fa-trash"></i></button></td>
                <td id="FName" style="display:none;">' . $thisRow["userFName"] . '</td>
                <td id="LName" style="display:none;">' . $thisRow["userLName"] . '</td>
                </tr>
        
                ';
                $counter += 1;
            }
            // <td><button type="button" name="edit" id="' . $thisRow["userId"] . '" class="btn btn-warning btn-xs edit"><i class="fas fa-user-edit"></i></button></td>

            echo $output;
            break;

        // case 'getUser':

        //     $output = '';
        //     $counter = 1;
        //     $usersResult = getUsers($conn);
        //     while ($thisRow = mysqli_fetch_assoc($usersResult)) {

        //         $output .= '  
        //             <tr>  
        //             <td>' . $counter . '</td>
        //             <td>' . $thisRow["userFName"] . ' ' . $thisRow["userLName"] . '</td>
        //             <td>' . $thisRow["userEmail"] . '</td>
        //             <td>' . $thisRow["userType"] . '</td>
        //             <td><button type="button" name="update" id="' . $thisRow["userId"] . '" class="btn btn-warning btn-xs update">Update</button></td>
        //             <td><button type="button" name="delete" id="' . $thisRow["userId"] . '" class="btn btn-danger btn-xs delete"><i class="fas fa-trash"></i></button></td>
        //             </tr>
            
        //             ';
        //         $counter += 1;
        //     }

        //     echo $output;
        //     break;
        case 'new':
        case 'update':
        case 'delete':
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

function getUseDetail($conn, $userEmail)
{
    $sql = "SELECT * FROM User WHERE userEmail='$userEmail'";
    $result = $conn->query($sql);
    $conn->next_result();
    echo $conn->error;
    return $result;
}
