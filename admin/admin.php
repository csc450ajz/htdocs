<!-- admin.php - admin page
      
    -->

<?php
//index.php
include('../util/db-config.php');
// ensure that user is admin, otherwise kick back to login page
include('../util/check-login.php');
// if (!checkAdmin()) {
//     header("Location: ../logIn.php");
// }


if (array_key_exists('hdnMessage', $_POST)) {
    if (isset($_POST['productMessage'])) {
        $chatId = $_POST['chatId'];
        $userEmail = $_SESSION['userEmail'];
        $messageText = $_POST['messageText'];
        // echo ($messageText);
        $sql = "INSERT INTO chatmessages (userEmail, chatId, messageText, messageSentTime) VALUES('$userEmail', '$chatId', '$messageText', CURRENT_TIMESTAMP)";
        $result = $conn->query($sql);
        // echo $result;
    } elseif (isset($_POST['issueMessage'])) {
        $userEmail = $_SESSION['userEmail'];
        $messageText = $_POST['issueText'];
        $issueType = $_POST['issueType'];

        $sql = "INSERT INTO issue (clientEmail, issueType, issueText, issueDateSubmitted) VALUES('$userEmail', '$issueType' ,'$messageText', CURRENT_TIMESTAMP)";
        $result = $conn->query($sql);

        $issueId = mysqli_insert_id($conn);
        $sql = "INSERT INTO adminmessages (clientEmail, issueId, messageText, messageTime) VALUES ('$userEmail', '$issueId', '$messageText', CURRENT_TIMESTAMP)";
        if ($conn->query($sql)) {
            $currentUrl = htmlentities($_SERVER['REQUEST_URI']);
            $tabTag = "#messages";

            header("Location: {$currentUrl}{$tabTag}");
            // echo '<script>$("a[href="#nav-messages"]").tab("show")</script>';
        }
    } elseif (isset($_POST['deleteChat'])) {
        $chatId = $_POST['deleteChat'];
        $sql = "DELETE FROM productChat WHERE chatId = '$chatId'";
        $conn->query($sql);
    }
}


?>

<!DOCTYPE html>
<html>
<?php
require_once('../util/config.html')
?>


<head>
    <title>Admin</title>
</head>

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
                                <div class="card-header">Quick Profile Info</div>
                                <img class="card-img-top" src="../images/profile.jpg" alt="Card image cap">
                                <div class="card-body text-dark">
                                    <h5 class="card-title">My Name</h5>
                                    <p class="card-text">User Details Below: email, username, etc.</p>
                                    <button>Edit Profile</button>
                                </div>
                            </div>
                        </div>


                        <div class="col-md-9">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-header"><strong>Total Users</strong></div>
                                        <div class="card-body" align="center">
                                            <h1>100</h1>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-header"><strong>Total Categories</strong></div>
                                        <div class="card-body" align="center">
                                            <h1>10</h1>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
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
                            </div>
                        </div>


                    </div>
                </div>
                <div class="tab-pane fade" id="messages" role="tabpanel" aria-labelledby="messages-tab">
                    <div class="row">
                        <div class="col-2">
                        <!-- <i class="fas fa-edit" data-toggle="modal" data-target="#messageModal" style="cursor: pointer;"></i> -->
                            <!-- <a href="#" class="btn btn-primary btn-" role="button" data-toggle="modal" data-target="#messageModal"><i class="fas fa-external-link-alt"></i></a> -->
                        </div>
                        <div class="col-10" style="margin: 0px;">
                            <h3>Messages</h3>
                            <i class="fas fa-edit" data-toggle="modal" data-target="#messageModal" style="cursor: pointer; float: right; margin-bottom: 5px;"></i>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-2">
                            <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                <a class="nav-link active" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home" aria-selected="true">Inbox</a>
                                <!-- <a class="nav-link" id="v-pills-inbox-tab" data-toggle="pill" href="#v-pills-inbox" role="tab" aria-controls="v-pills-inbox" aria-selected="false">Sent</a> -->
                            </div>
                        </div>
                        <div class="col-10">
                            <div class="tab-content" id="v-pills-tabContent">
                                <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
                                    <h5>Messages With Sellers and Buyers</h5>
                                    <?php
                                    require_once('../util/messages/messages.php');

                                    ?>
                                </div>
                                <!-- <div class="tab-pane fade" id="v-pills-inbox" role="tabpanel" aria-labelledby="v-pills-inbox-tab">...</div> -->
                            </div>
                        </div>


                    </div>
                </div>
                <div class="tab-pane fade" id="users" role="tabpanel" aria-labelledby="city-attractions-tab">
                    <p>Users</p>
                </div>

                <div class="tab-pane fade" id="categories" role="tabpanel" aria-labelledby="city-attractions-tab">
                    <p>Categories</p>
                </div>
            </div>
        </div>




    </div>
</body>

</html>