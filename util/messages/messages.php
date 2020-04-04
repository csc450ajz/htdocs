<!DOCTYPE html>
<html lang="en">

<?php
include('../util/db-config.php');
// include('../../util/db-config.php');

require_once('message-utility.php');
$messageResult = getProductMessage($conn);


?>


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    <title>Messages</title>
</head>

<body>
    <form action="<?php echo htmlentities($_SERVER['REQUEST_URI']); ?>" method="POST">

        <div class="table-responsive">

            <table class="table">
                <?php while ($thisRow = $messageResult->fetch_assoc()) {
                    $chatId = $thisRow['chatId']; ?>
                    <tr>
                        <input type='hidden' name='hdnMessage' value='true' />

                        <!-- <td class="inbox-small-cells"><i class="fa fa-star"></i></td> -->
                        <td class="sender"><?= $thisRow['recentSender'] ?></td>
                        <td class="content"><?= $thisRow['productId'] ?></td>
                        <!-- <td class="view-message inbox-small-cells"><i class="fa fa-paperclip"></i></td> -->
                        <td class="date"><?= $thisRow['messageSentTime'] ?></td>
                        <td> <input type="button" name="view" value="view" class="viewDetail btn btn-primary btn-sm" id="<?= $thisRow['chatId'] ?>" /></td>
                        <td><button type="submit" name="deleteChat" value="<?= $thisRow['chatId'] ?>" class="btn btn-danger">Delete</button></td>
                    </tr>

                <?php }
                ?>

            </table>

        </div>
    </form>


    <script>
        $(document).ready(function() {
            $('.viewDetail').click(function() {
                var chatId = $(this).attr("id");
                fetchMessageDetails(chatId);
                $('#dataModal').modal("show");
            });

            $('#issueMessage').click(function() {
                // alert("Got Clicked");
                // var hrefVal = ('#nav-messages-tab').attr("href");
                // var fullUrl = window.location.href + hrefVal;
                // var issueType = ('#issueType').val()
                // var issueText=('#issueText').val()


                // $.ajax({
                //     url: fullUrl,
                //     method: "post",
                //     data: {
                //         issueType: issueType,
                //         issueText: issueText
                //     },
                //     success: function(data) {
                //         console.log(data)
                //         // $('#messageDetail').html(data);
                //         // $('#dataModal').modal("show");
                //     }
                // });
                // console.log("chatId");
                // event.preventDefault();
            });

            $('#frmProductMessage').on('submit', function(event) {

                event.preventDefault();
                var messageText= $('#messageText').val()
                var chatId = $('.chatId').val()
                $.ajax({
                    url: "admin.php",
                    type: "POST",
                    data: {
                        hdnMessage: true,
                        productMessage: true,
                        messageText: messageText,
                        chatId: chatId
                    }
                }).done(function(msg) {
                    fetchMessageDetails(chatId)
                });
            });

            function fetchMessageDetails(chatId) {
                $.ajax({
                    url: "../util/messages/messageAJAX.php",
                    method: "post",
                    data: {
                        chatId: chatId
                    },
                    success: function(data) {
                        console.log(data)
                        $('#messageDetail').html(data);
                        // $('#dataModal').modal("show");
                    }
                });
            }

            // $('#nav-messages-tab').click(function() {
            //     var loc = $(this).attr("href");
            //     console.log(window.location.href + loc)
            // })
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

                <form action="<?php echo htmlentities($_SERVER['SCRIPT_FILENAME']); ?>" method="POST" name="frmProductMessage" id="frmProductMessage">
                    <div class="modal-body" id="messageDetail">
                        <!-- window.location.href -->


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
                    <h5 class="modal-title" id="exampleModalLabel">Send New Message to Admin</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?php echo htmlentities($_SERVER['REQUEST_URI']); ?>" method="POST" name="frmMessage" id="frmIssueMessage">
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