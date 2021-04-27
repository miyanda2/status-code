<?php

    require_once './functions.php';
    isUserLoggedIn();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link rel="stylesheet" href="./css/style.css">
</head>

<body>
    <div class="container register-form">

        <div class="form">
            <h1 class="text-center mb-4">Hello User</h1>
            <a href="logout.php" class="btn btn-danger">Logout</a>
            <div class="note">
                <p>Dashboard</p>
            </div>

            <div class="form-content">
                <form id="frmConfig" method="POST">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="errMsg"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="URL" name="url" />
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Email" name="email"/>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="dropdown">
                                <div class="form-group">
                                    <select name="status" class="form-control">
                                        <option value="-1">Select Http Status</option>
                                        <option value="200">200</option>
                                        <option value="301">301</option>
                                        <option value="302">302</option>
                                        <option value="304">304</option>
                                        <option value="307">307</option>
                                        <option value="400">400</option>
                                        <option value="403">403</option>
                                        <option value="404">404</option>
                                        <option value="500">500</option>
                                        <option value="501">501</option>
                                        <option value="502">502</option>
                                        <option value="504">504</option>
                                        <option value="507">507</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <select name="frequency" class="form-control">
                                        <option value="-1">Select Frequency of Check</option>
                                        <option value="5">5 Minutes</option>
                                        <option value="10">10 Minutes</option>
                                        <option value="15">15 Minutes</option>
                                        <option value="20">20 Minutes</option>
                                        <option value="25">25 Minutes</option>
                                        <option value="30">30 Minutes</option>
                                        <option value="60">1 Hour</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="button" id="btnConfig" class="btn btn-primary btn-block mt-5">Submit</button>
                </form>
            </div>
        </div>
    </div>
</body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script>

    function formatErrorMessage(jqXHR, exception) 
    {
        if (jqXHR.status === 0) {
            return ('Not connected.\nPlease verify your network connection.');
        } else if (jqXHR.status == 404) {
            return ('The requested page not found. [404]');
        } else if (jqXHR.status == 500) {
            return ('Internal Server Error [500].');
        } else if (exception === 'parsererror') {
            return ('Requested JSON parse failed.');
        } else if (exception === 'timeout') {
            return ('Time out error.');
        } else if (exception === 'abort') {
            return ('Ajax request aborted.');
        } else {
            return ('Uncaught Error.\n' + jqXHR.responseText);
        }
    }


    $(document).on('click', '#btnConfig', function(e){
        e.preventDefault();
        var formData = $('#frmConfig').serialize();
        var displayMessage = $('.errMsg');

        swal("Please wait...");
        displayMessage.html('<div class="alert alert-info mt-3 text-center" role="alert"> Please wait... </div>');

        $.ajax({
            async: true,
            url: 'ajaxSaveConfig.php',
            type: 'POST',
            data: formData,
            success: function (msg) {
                if(msg == 'success'){
                    $('#frmConfig')[0].reset();
                    swal("Good job!", "Data Successfully Saved.", "success");
                    displayMessage.html('<div class="alert alert-success text-center" role="alert"> Data Successfully Saved. </div>');
                    setTimeout((function(){ location.reload() }), 3000);
                }else{
                    displayMessage.html('<div class="alert alert-danger text-center" role="alert"> '+msg+' </div>');
                    swal("Oops!", ""+msg+"", "error");
                }
            },
            error: function(x,e) {            
                displayMessage.html('<div class="alert alert-danger text-center" role="alert"> '+formatErrorMessage(x, e)+' </div>');
                swal("Oops!", ""+formatErrorMessage(x, e)+"", "error");
            }
        })
    });
</script>


</html>