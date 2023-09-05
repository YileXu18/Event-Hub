<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Home - Event</title>
    <!-- css -->
    <link rel="stylesheet" href="css/main.css" />
    <meta name="google-signin-client_id" content="666140629361-6j1448jspv77k92mubcl5s4pbhigvn4c.apps.googleusercontent.com">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">
    <!-- Optional theme -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/css/bootstrap-theme.min.css" integrity="sha384-6pzBo3FDv/PJ8r2KRkGHifhEocL+1X2rVCTTkUfGk7/0pbek5mMa1upzvWbrUbOZ" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/js/bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script>
</head>
<body>
<div>
    <div class="modal fade" id="confirmModal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title" id="modal-title">
                    </h2>
                    <h4 id="confirmLabel"></h4>
                </div>
                <input type="hidden" id="dataId">
                <div class="modal-footer form-inline">
                    <!-- <input type="button" class="btn btn-info  form-control" data-dismiss="modal"  aria-hidden="true" value="Cancel"></input> -->
                    <input type="button" class="btn btn-danger form-control" value="Confirm" id="btnConfirm" data-dismiss="modal">
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function showConfirmModal(title, content, callback) {
        $('#modal-title').html(title);
        $('#confirmLabel').html(content);
        $('#btnConfirm').on('click', callback);
        $('#confirmModal').modal('show');
    }
    $(function(){
        <?php if (isset($_GET['k']) && $_GET['k'] == 'create') {?>
        showConfirmModal('', "<p style='color:green;font-size:18px;'>You event has been created! </p>", function () {
            window.location.href = "index.php";
        });
        <?php } else if (isset($_GET['k']) && $_GET['k'] == 'edit') { ?>
        var id = <?=$_GET['eventId']?>;
        showConfirmModal('', "<p style='color:green;font-size:18px;'>Edit complete!! </p>", function () {
            window.location.href = "event_details.php?eventId="+id;
        });
        <?php } else if (isset($_GET['k']) && $_GET['k'] == 'report') { ?>
        showConfirmModal('', "<p style='color:green;font-size:18px;'>report received!! </p>", function () {
            window.location.href = "index.php";
        });
        <?php } else if (isset($_GET['k']) && $_GET['k'] == 'u21_create') { ?>
        showConfirmModal('', "<p style='color:red;font-size:18px;'>you are under 21，unable to create alcohol involved type event!! </p>", function () {
            window.location.href = "index.php";
        });
        <?php } else if (isset($_GET['k']) && $_GET['k'] == 'u21_show') { ?>
        showConfirmModal('', "<p style='color:red;font-size:18px;'>You are under 21，unable to see this event detail!! </p>", function () {
            window.location.href = "index.php";
        });
        <?php } ?>
    })
</script>
</body>
</html>
