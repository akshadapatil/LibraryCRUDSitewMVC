function validateForm()
{
    var username = $("#username").val();
    var password = $("#password").val();
    
    if ( username == "" && password == ""){
        alert ("Please fill up the form");
        return false;
    }
    else{
        $("form").submit();
    }
}