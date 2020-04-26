<?php
require_once('../util/config.php');
// ensure that user is admin, otherwise kick back to login page
if (!checkAdmin()) {
    header("Location: ../logIn.php");
}


if (array_key_exists('hdnIssue', $_POST)) {
    if (isset($_POST['adminMessage'])) {
        $issueId = $_POST['issueId'];
        $userEmail = $_POST['userEmail'];
        $messageText = $_POST['messageText'];
        // echo ($messageText);
        $sql = "INSERT INTO adminmessages (clientEmail, issueId, messageText, messageTime) VALUES('$userEmail', '$issueId', '$messageText', CURRENT_TIMESTAMP)";
        $result = $conn->query($sql);
        // echo $result;
    } elseif (isset($_POST['deleteIssue'])) {
        $issueId = $_POST['issueId'];
        $sql = "DELETE FROM issue WHERE issueId='$issueId'";
        if ($conn->query($sql)) {
            $currentUrl = htmlentities($_SERVER['REQUEST_URI']);
            $tabTag = "{$tabTag}#messages";
            header("Location: {$currentUrl}{$tabTag}");
            // echo '<script>$("a[href="#nav-messages"]").tab("show")</script>';
        }
    }
}

function countCategories($conn)
{
    $sql = "SELECT * FROM Category";
    $result = $conn->query($sql);
    $total = mysqli_num_rows($result);
    $conn->next_result();
    echo $conn->error;
    return $total;
}

function countUsers($conn)
{
    $sql = "SELECT * FROM User";
    $result = $conn->query($sql);
    $total = mysqli_num_rows($result);
    $conn->next_result();
    echo $conn->error;
    return $total;
}



?>

<!DOCTYPE html>
<html>
<?php
require_once(("../util" . $navbar));
?>


<head>
    <title>Admin</title>
</head>

<style>
    .nav-mytabs {
        margin-top: 2rem;
    }

    .nav-mytabs li:not(:last-child) {
        margin-right: 7px;
    }

    .nav-mytabs a {
        position: relative;
        top: 4px;
        padding: 10px 25px;
        border-radius: 2px 2px 0 0;
        background: lightslategray;
        color: white;
        opacity: 0.7;
        transition: all 0.1s ease-in-out;
    }

    .nav-mytabs a.active,
    .nav-mytabs a:hover {
        opacity: 1;
        top: 0;
    }
</style>
<script>
    $(document).ready(() => {
        let url = location.href.replace(/\/$/, "");
        if (location.hash) {
            const hash = url.split("#");
            $('#myTab a[href="#' + hash[1] + '"]').tab("show");
            url = location.href.replace(/\/#/, "#");
            history.replaceState(null, null, url);
            setTimeout(() => {
                $(window).scrollTop(0);
            }, 400);
        }

        $('a[data-toggle="tab"]').on("click", function() {
            let newUrl;
            const hash = $(this).attr("href");
            if (hash == "#nav-home") {
                newUrl = url.split("#")[0];
            } else {
                newUrl = url.split("#")[0] + hash;
            }
            newUrl += "/";
            history.replaceState(null, null, newUrl);
        });
    });
</script>
<? $navbar ?>

<body>
    <div class="jumbotron jumbotron-fluid">
        <div class="container">

            <ul class="nav nav-mytabs" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="messages-tab" data-toggle="tab" href="#messages" role="tab" aria-controls="messages" aria-selected="false">Messages</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="users-tab" data-toggle="tab" href="#users" role="tab" aria-controls="users" aria-selected="false">Users</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" id="categories-tab" data-toggle="tab" href="#categories" role="tab" aria-controls="categories" aria-selected="false">Categories</a>
                </li>
            </ul>
            <div class="tab-content mytab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                    <br>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="card border-dark mb-3 " style="margin-bottom: unset!important;">
                                <?PHP
                                $userEmail = $_SESSION['userEmail'];
                                $sql = "SELECT * FROM User WHERE User.userEmail = '$userEmail' LIMIT 1;";
                                $result = $conn->query($sql);
                                $row = mysqli_fetch_assoc($result);
                                ?>
                                <div class="card-header">Quick Profile Info</div>
                                <img id="profile-pic" class="card-img-top" src="../<?PHP echo $row['userPhotoPath'] ?>" onerror="this.src='../images/placeholder.jpg';" alt="Profile picture">
                                <div class="card-body text-dark">
                                    <h5 class="card-title"><?PHP echo $row['userFName'] . " " . $row['userLName']; ?></h5>
                                    <dl>
                                        <dt>Email:</dt>
                                        <dd><?PHP echo $row['userEmail']; ?></dd>
                                        <dt>Cash Balance:</dt>
                                        <dd>$<?PHP echo $row['userBalance']; ?></dd>
                                    </dl>
                                    <form action="/client/editProfile.php">
                                        <button type="submit">Edit Profile</button>
                                    </form>
                                </div>
                            </div>
                        </div>


                        <div class="col-md-9">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card border-dark mb-3">
                                        <div class="card-header"><strong>Total Users</strong></div>
                                        <div class="card-body" align="center">
                                            <h1><?= countUsers($conn) ?></h1>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 border-dark mb-3">
                                    <div class="card">
                                        <div class="card-header"><strong>Total Categories</strong></div>
                                        <div class="card-body" align="center">
                                            <h1><?= countCategories($conn) ?></h1>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <!-- <div class="row">
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-header"><strong>Unread Messages</strong></div>
                                        <div class="card-body" align="center">
                                            <h1>15</h1>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-header"><strong>Coupons</strong></div>
                                        <div class="card-body" align="center">
                                            <h1>8</h1>
                                        </div>
                                    </div>
                                </div>
                            </div> -->
                        </div>


                    </div>
                </div>
                <div class="tab-pane fade" id="messages" role="tabpanel" aria-labelledby="messages-tab">

                    <h3>Messages</h3>

                    <?php
                    require_once('../admin/messages/messages.php');

                    ?>


                </div>
                <div class="tab-pane fade" id="users" role="tabpanel" aria-labelledby="city-attractions-tab">
                    <br>
                    <?php
                    require_once('users/users.php');

                    ?>
                </div>

                <div class="tab-pane fade" id="categories" role="tabpanel" aria-labelledby="city-attractions-tab">
                    <br>
                    <?php
                    require_once('categories/categories.php');

                    ?>
                </div>
            </div>
        </div>




    </div>
    <?php
    require_once('./../footer.html');

    ?>


</body>

</html>