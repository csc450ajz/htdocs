<?php
require_once('../../util/db-config.php');
if (isset($_POST['categoryActions'])) {
    $actions = $_POST['categoryActions'];

    switch ($actions) {
        case 'getCategories':
            $output = '';
            $categoriesResult = getCategories($conn);
            while ($thisRow = mysqli_fetch_assoc($categoriesResult)) {
                $status = '';
                if ($thisRow['categoryStatus'] == 'active') {
                    $status = '<span class="badge badge-success">Active</span>';
                } else {
                    $status = '<span class="badge badge-danger">Inactive</span>';
                }
                $output .= '  
                <tr>  
                <td id="categoryId">' . $thisRow['categoryId'] . '</td>
                <td id="categoryName">' . $thisRow["categoryName"] . '</td>
                <td id="categoryStatus">' . $status . '</td>
                <td><button type="button" name="edit" id="' . $thisRow["categoryId"] . '" class="btn btn-warning btn-xs editCat"><i class="fas fa-edit"></i></button></td>
                <td><button type="button" name="delete" id="' . $thisRow["categoryId"] . '" class="btn btn-danger btn-xs deleteCat"><i class="fas fa-trash"></i></button></td>
                </tr>
        
                ';
            }

            echo $output;
            break;

        case 'getCategory':

            $output = [];
            $categoryId = $_POST['categoryId'];
            $categoryResult = getCategoryDetail($conn, $categoryId);
            while ($thisRow = mysqli_fetch_assoc($categoryResult)) {

                $output['categoryId'] = $thisRow['categoryId'];
                $output['categoryName'] = $thisRow['categoryName'];
                $output['categoryStatus'] = $thisRow['categoryStatus'];
            }
            // echo $output;
            echo json_encode($output);
            break;

        case 'new':
            $result = createCategory($conn, $_POST['categoryName'], $_POST['categoryStatus']);
            if ($result) {
                echo ("Created New Category");
            }
            break;

        case 'update':
            $result = updateCategory($conn, $_POST['categoryId'], $_POST['categoryName'], $_POST['categoryStatus']);
            if ($result) {
                echo ("Update Category");
            }
            break;

        case 'delete':
            $result = deleteCategory($conn, $_POST['categoryId']);
            if ($result) {
                echo ("Updated Category status");
            }
            break;

        default:
            break;
    }
}

function getCategories($conn)
{
    $sql = "SELECT * FROM Category";
    $result = $conn->query($sql);
    $conn->next_result();
    echo $conn->error;
    return $result;
}

function getCategoryDetail($conn, $categoryId)
{
    $sql = "SELECT * FROM Category WHERE categoryId='$categoryId'";
    $result = $conn->query($sql);
    $conn->next_result();
    echo $conn->error;
    return $result;
}


function createCategory($conn, $categoryName, $categoryStatus)
{
    $sql = "INSERT INTO category (categoryId, categoryName, categoryStatus) VALUES (NULL, '$categoryName','$categoryStatus')";
    $result = $conn->query($sql);
    $conn->next_result();
    echo $conn->error;
    return $result;
}

function updateCategory($conn, $categoryId, $categoryName, $categoryStatus)
{
    $sql = "UPDATE category SET categoryName='$categoryName', categoryStatus='$categoryStatus' WHERE categoryId= '$categoryId'";
    $result = $conn->query($sql);
    $conn->next_result();
    echo $conn->error;
    return $result;
}

function deleteCategory($conn, $categoryId)
{
    $sql = "UPDATE category SET categoryStatus='inactive' WHERE categoryId= '$categoryId'";
    $result = $conn->query($sql);
    $conn->next_result();
    echo $conn->error;
    return $result;
}
