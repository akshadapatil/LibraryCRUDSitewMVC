<html>
    <head>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/user.css">
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js" type="text/javascript"></script>
        <script type="text/javascript" src="<?php echo base_url();?>js/user.js" defer></script>
    </head>
    <body>
        <div id="container">
            <div id="form-header">Sign Up Form</div>
            <form name="signupForm" action="signup" method="POST" onsubmit="return validateForm();">
                <?php if(isset($error)) {?> <div id="error-msg">*<?php echo $error;?></div> <?php } ?>
                <div><span> User Name :</span><input type="text" name="username" id="username" /></div>
                <div><span> Password : </span><input type="password" name="password" id="password" /></div>
                <div><input type="submit" value="Submit"></div>
            </form>
        </div>
    </body>
</html>