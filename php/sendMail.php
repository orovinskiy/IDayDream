<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <!-- Styles -->
    <link rel="stylesheet" href="../styles/sendMail.css">

    <title>Send Emails</title>
</head>
<body>
<div class="container">
    <div class="jumbotron banner">
        <h1>Compose Your Email</h1>
    </div>
    <form id="emailComposer" action="mailSender.php" method="post">

        <!-- Subject -->
        <div class="form-group" >
            <label class=" h5 font-weight-light " id="subjectLabel"  for="subject">Subject </label>
            <span id="subjectError" class="hidden error">*Required</span>
            <input class="required form-control" type="text" id="subject" maxlength="150" name="subject">
        </div>

        <!-- Text Area -->
        <div class="form-group">
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

        <button type="submit" id="submit" class="btn btn-dark p-2">Submit</button>
    </form>
</div>

</body>
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script src="../javascript/sendMail.js"></script>

</html>