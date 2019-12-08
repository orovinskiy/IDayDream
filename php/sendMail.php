<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
    <!-- Bootstrap core CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <!-- Material Design Bootstrap -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.8.11/css/mdb.min.css" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="../styles/sendMail.css">
    <link rel="stylesheet" href="../styles/style.css">
    <link rel="stylesheet" href="../styles/form.css">

    <!-- Favicon -->
    <link rel="shortcut icon" href="../images/favicon.png"/>

    <title>Send Email</title>
</head>
<body class="bg-color">

<!-- Header -->
<div class="jumbotron banner">
    <h1 class="display-4 text-white font-weight-bold">Email</h1>
</div>

<div class="container width">
    <div class="col-md-12">
        <section class="card shadow mb-5">
            <h3 class="card-title titleColor text-white text-center mb-4 py-2">Compose Your Email</h3>

            <fieldset class="form-group m-0 p-4">
                <form id="emailComposer" action="mailSender.php" method="post">
                    <!-- From -->
                    <div class="form-group">
                        <label class=" h5 font-weight-light " id="fromLabel"  for="from">From</label>
                        <span id="fromError" class="hidden error">*Required</span>
                        <input class="required form-control" type="text" id="from" maxlength="50" name="from">
                    </div>

                    <!-- Subject -->
                    <div class="form-group" >
                        <label class=" h5 font-weight-light " id="subjectLabel"  for="subject">Subject </label>
                        <span id="subjectError" class="hidden error">*Required</span>
                        <input class="required form-control" type="text" id="subject" maxlength="150" name="subject">
                    </div>

                    <!-- Text Area -->
                    <div class="form-group mb-0">
                        <label for="compose" id="composeLabel" class="h5 font-weight-light mr-sm-1">
                            Compose your message
                        </label>
                        <span id="composeError" class="hidden error">*Required</span>
                        <textarea id="compose" maxlength="200000" class="required form-control" name="compose"></textarea>
                    </div>

                    <!-- saves input from which page the user came from -->
                    <?php
                    $page = $_GET['source'];
                    if($page === 'dream'){
                        echo "<input type='checkbox' name='select' value='dream' checked class='halfHidden'>";
                    }
                    else{
                        echo "<input type='checkbox' name='select' value='vol' checked class='halfHidden'>";
                    }
                    ?>

                    <button type="submit" id="submit" class="btn btn-dark shadow-sm my-0">Submit</button>
                </form>
            </fieldset>
        </section>
    </div>
</div>

</body>
<!-- JQuery -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<!-- Bootstrap tooltips -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.4/umd/popper.min.js"></script>
<!-- Bootstrap core JavaScript -->
<script type="text/javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.min.js"></script>
<!-- MDB core JavaScript -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.8.11/js/mdb.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script>
<script src="../javascript/sendMail.js"></script>
</html>