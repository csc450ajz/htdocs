<!DOCTYPE html>
<html lang="en">

<?php
include('../util/db-config.php');
// include('../../util/db-config.php');

require_once('message-utility.php');
$messageResult = getIssueMessages($conn);



?>


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script> -->

    <title>Messages</title>
</head>

<body>
    <form action="<?php echo htmlentities($_SERVER['REQUEST_URI']); ?>" method="POST">

        <div class="table-responsive">

            <table class="table">
                <thead>
                    <tr>
                        <th>From</th>
                        <th>Issue Type</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <?php while ($thisRow = $messageResult->fetch_assoc()) {
                    $userResult = getUserDetail($conn, $thisRow['clientEmail']);
                    $userDetail = $userResult->fetch_assoc();

                ?>
                    <tr>
                        <input type='hidden' name='hdnMessage' value='true' />
                        <td class="sender"><?= $userDetail['userFName'] ?> <?= $userDetail['userLName'] ?></td>
                        <td class="content"><?= $thisRow['issueType'] ?></td>
                        <td class="date"><?= $thisRow['issueDateSubmitted'] ?></td>
                        <td> <input type="button" name="view" value="view" class="view btn btn-primary btn-sm" id="<?= $thisRow['issueId'] ?>" /></td>
                        <!-- <td><i id="<?= $thisRow['issueId'] ?>" class="fas fa-trash delete" style="cursor: pointer; color: red;"></i></td> -->
                        <td><button type="button" id="<?= $thisRow['issueId'] ?>" class="btn btn-danger btn-sm delete"><i class="fas fa-trash"></i></button></td>

                        <!-- <td><button type="submit" name="deleteIssue" value="<?= $thisRow['issueId'] ?>" class="btn btn-danger btn-sm">Delete</button></td> -->

                        <!-- <td><button type="submit" name="deleteChat" value="<?= $thisRow['chatId'] ?>" class="btn btn-danger btn-sm">Delete</button></td> -->
                    </tr>

                <?php }
                ?>

            </table>

        </div>
    </form>



    <script>
        $(document).ready(function() {
            $('.view').click(function() {
                var issueId = $(this).attr("id");
                getMessageDetails(issueId);
                $('#detailModal').modal("show");
            });

            $('.delete').click(function() {

                var issueId = $(this).attr("id");
                $.ajax({
                    url: "client.php",
                    method: "POST",
                    data: {
                        // hdnIssue: true,
                        deleteIssue: true,
                        issueId: issueId
                    }
                }).done(function(msg) {
                    location.reload();
                });
            })

            $('#frmClientIsue').on('submit', function(event) {
                console.log("issueId, userEmail, messageText")

                event.preventDefault();

                var messageText = $('#messageText').val()
                var issueId = $('.issueId').val()
                var userEmail = $('#userEmail').val()
                $.ajax({
                    url: "client.php",
                    type: "POST",
                    data: {
                        // hdnIssue: true,
                        adminMessage: true,
                        messageText: messageText,
                        issueId: issueId,
                        userEmail: userEmail
                    }
                }).done(function(msg) {
                    getMessageDetails(issueId)
                });
            });

            function getMessageDetails(issueId) {
                $.ajax({
                    url: "messages/messageAJAX.php",
                    method: "post",
                    data: {
                        issueId: issueId
                    },
                    success: function(data) {
                        $('#issueMessageDetail').html(data);
                    }
                });
            }

        });
    </script>
    <!-- Modal -->
    <div class="modal fade" id="detailModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Message Details</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form action="<?php echo htmlentities($_SERVER['SCRIPT_FILENAME']); ?>" method="POST" name="frmClientIssue" id="frmClientIsue">
                    <div class="modal-body" id="issueMessageDetail">


                    </div>
                </form>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <!-- <button name="btnSubmit" value="new" type="submit" class="btn btn-primary">Send</button> -->
                </div>
            </div>
        </div>
    </div>

</body>

</html>