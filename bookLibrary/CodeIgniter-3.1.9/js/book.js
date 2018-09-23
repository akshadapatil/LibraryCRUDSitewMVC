var BOOK = function(){
    
    var showAddBookPopup = function(e) {
        e.preventDefault();
        $("body").css("overflow", "hidden");
        $("#addBookPopup").css("display", "block");
    };
    
    var submitAddBookFormPopup = function() {
        
        if ($('#totalBooks').val() <= 0 || $('#totalBooks').val() > 1000)
        {
            alert("Total number of books can range only between 1 to 1000");
            return false;
        }
        
        //To check for empty fields.
        if ($('#bookName').val() == "" || $("#bookTypes").val() == "" || $('#totalBooks').val() == "") {
            alert("Fill All Fields !");
        }
        else {
            // AJAX Code To Submit Form.
            var formData = {
                'name'       : $('#bookName').val(),
                'type'       : $("#bookTypes").val(),
                'totalBooks' : $("#totalBooks").val()
            };
            $.ajax({
                type    : "POST",
                url     : 'index.php/book/addBook',
                data    : formData,
                success: function(result){
                    alert(result);
                    $("#addBookPopup").css("display", "none");
                    $("body").css("overflow", "visible");
                    window.location.reload();
                }
            });
            return false;
        }
    };
    
    var closeAddBookFormPopup = function() {
        $("#addBookPopup").css("display", "none");
        $("body").css("overflow", "visible");
    };
      
    var borrowBook = function()
    {
        var borrowBookData = {
            'idbooks' : $(this).parent().attr("value")
        };

         $.ajax({
            type    : "POST",
            url     : 'index.php/book/borrowBook',
            data    : borrowBookData,
            success: function(result){
                alert(result);
                window.location.reload();
            }
        });
        return false;
    };
    
    var returnBook = function()
    {
        var returnBookData = {
            'idbooks' : $(this).parent().attr("value")
        };

        $.ajax({
            type    : "POST",
            url     : 'index.php/book/returnBook',
            data    : returnBookData,
            success: function(result){
                alert(result);
                window.location.reload();
            }
        });
        return false;
    };
    
    var checkBookAvailability = function()
    {
        var bookData = {
            'idbooks' : $(this).parent().attr("value")
        };

        $.ajax({
            type    : "POST",
            url     : 'index.php/book/checkBookAvailability',
            data    : bookData,
            success: function(result){
                debugger;
                if (result > 0)
                {
                    alert ("Book is available");
                }
                else
                {
                    alert("Book is unavailable");
                }
            }
        });
        return false;
    }
    
    var logout = function()
    {
        $.ajax({
            type    : "POST",
            url     : 'index.php/book/logout',
            success: function(result){
                window.location.reload();
            }
        });
        return false;
    };
      
    var bindEvents = function() {
        $("#add-book").bind("click", showAddBookPopup);  
        $("#submitBook").bind("click", submitAddBookFormPopup);
        $("#close-button").bind("click", closeAddBookFormPopup);
       $(".borrow").bind("click", borrowBook);
       $(".return").bind("click", returnBook);
       $("#logout").bind("click", logout);
       $(".available").bind("click", checkBookAvailability);
    };
    
    bindEvents();
}();