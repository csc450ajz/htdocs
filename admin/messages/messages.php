<!DOCTYPE html>
<html lang="en">

<?php

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
                        <input type='hidden' name='hdnIssue' value='true' />
                        <input type='hidden' name='issueId' value='<?= $thisRow['issueId'] ?>' />

                        <td class="sender"><?= $userDetail['userFName'] ?> <?= $userDetail['userLName'] ?></td>
                        <td class="content"><?= $thisRow['issueType'] ?></td>
                        <td class="date"><?= $thisRow['issueDateSubmitted'] ?></td>
                        <td> <input type="button" name="view" value="view" class="viewDetail btn btn-primary btn-sm" id="<?= $thisRow['issueId'] ?>" /></td>
                        <!-- <td><i id="<?= $thisRow['issueId'] ?>"  class="fas fa-trash deleteIssue" style="cursor: pointer; color: red;"></i></td> -->

                        <td><button type="submit" name="deleteIssue" value="<?= $thisRow['issueId'] ?>" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button></td>

                        <!-- <td><button type="submit" name="deleteChat" value="<?= $thisRow['chatId'] ?>" class="btn btn-danger btn-sm">Delete</button></td> -->
                    </tr>

                <?php }
                ?>

            </table>

        </div>
    </form>



    <script>
        $(document).ready(function() {
            $('.viewDetail').click(function() {
                var issueId = $(this).attr("id");
                fetchMessageDetails(issueId);
                $('#dataModal').modal("show");
            });

            $('.deleteIssue').click(function() {

                var issueId = $(this).attr("id");
                $.ajax({
                    url: "admin.php",
                    method: "POST",
                    data: {
                        hdnIssue: true,
                        deleteIssue: true,
                        issueId: issueId
                    }
                }).done(function(msg) {
                    location.reload();
                });
            })



            $('#frmIssueMessages').on('submit', function(event) {

                event.preventDefault();
                var messageText = $('#messageText').val()
                var issueId = $('#issueId').val()
                var userEmail = 'admin@admin.com';
                console.log(messageText, issueId, userEmail)
                $.ajax({
                    url: "admin.php",
                    method: "POST",
                    data: {
                        hdnIssue: true,
                        adminMessage: true,
                        messageText: messageText,
                        issueId: issueId,
                        userEmail: userEmail
                    },
                    success: function(msg) {
                        fetchMessageDetails(issueId)
                    }
                })
            });

            function fetchMessageDetails(issueId) {
                $.ajax({
                    url: "messages/messageAJAX.php",
                    method: "POST",
                    data: {
                        issueId: issueId
                    },
                    success: function(data) {
                        console.log(data)
                        $('#messageDetail').html(data);
                    }
                });
            }

        });
    </script>
    <!-- Modal -->
    <div class="modal fade" id="dataModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Message Details</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form name="frmIssueMessages" id="frmIssueMessages">
                    <div class="modal-body" id="messageDetail">


                    </div>
                </form>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <!-- <button name="btnSubmit" value="new" type="submit" class="btn btn-primary">Send</button> -->
                </div>
            </div>
        </div>
    </div>



    <!-- <button type="button" name="add" id="add_button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#messageModal">New Message</button> -->


    <!-- Modal -->
    <div class="modal fade" id="messageModal" tabindex="-1" role="dialog" aria-labelledby="messageModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Send Message to User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?php echo htmlentities($_SERVER['REQUEST_URI']); ?>" method="POST" name="frmMessage" id="frmMessage">
                    <div class="modal-body">

                        <div class="form-group">
                            <label for="txtIssue">Issue Type</label>
                            <input type="text" name="issueType" id="issueType" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="txtMessage">Message</label>
                            <textarea name="issueText" id="issueText" class="form-control" rows="3" placeholder="Enter message"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <!-- Use a hidden field to tell server if return visitor -->
                        <input type="hidden" name="hdnMessage" value="true" />
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button name="issueMessage" value="new" type="submit" class="btn btn-primary" id="issueMessage">Send</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</body>

</html>