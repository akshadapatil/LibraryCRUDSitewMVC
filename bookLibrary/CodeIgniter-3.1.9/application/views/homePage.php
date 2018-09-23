<html>
    <head>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/book.css">
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js" type="text/javascript"></script>
        <script type="text/javascript" src="<?php echo base_url();?>js/book.js" defer></script>
    </head>
    <body>
        <div id="container">
            <div id="welcome-title">Welcome to the Online Book Library System! </div>
            <div id="signup-container">
                <?php if ($loggedIn == "true")
                {?>
                    <span id="memeber">Hi <?php echo ucfirst($username); ?></span>
                    <span id="logout">| &nbsp;Log Out</span>
                <?php }
                else { ?>
                    <a href="index.php/user/login" id="login">Log In &nbsp;&nbsp; | &nbsp;&nbsp; </span>
                    <a href="index.php/user/index" id="signup">Sign Up</a>
                <?php } ?>
            </div>
            <div class="clear"></div>
            <?php if (isset($isAdmin) && $isAdmin == "true") { ?>
                <div id="crud-container">
                    <span id="add-book">Add A Book </span>
                </div>
            <?php } ?>
            <div id="main-content">

                <?php
                    if (isset($listOfBooks) && count($listOfBooks) > 0)
                    {
                        $bookNumber = 1;
                        ?> 
                        <div id="title">List of Books :</div>
                        <table id="books-display">
                            <tr id="table-header">
                                <th>No.</th>
                                <th>Book Name.</th>
                                <th>Type Of Book.</th>
                                <?php if ($loggedIn == "true"){?><th colspan="3">Action</th><?php }?>
                            </tr>
                            
                        <?php foreach ($listOfBooks as $book)
                        {
                            ?>
                            <tr><td><?php echo $bookNumber;?></td>
                                <td><?php echo $book->name;?></td>
                                <td><?php echo $book->type;?></td>
                                <?php if ($loggedIn == "true"){?>
                                <td id="record-<?php echo $book->idbooks;?>" value="<?php echo $book->idbooks;?>">
                                    <span class="borrow">Borrow</span>  
                                    <?php if (!empty($bookIssued)) {
                                        foreach ($bookIssued as $bookIssue) {
                                            if ($bookIssue['idbooks'] == $book->idbooks) { ?>
                                            <span class="return">Return</span>
                                    <?php }
                                        }
                                    }?>
                                    <span class="available">Availability</span>
                                </td>
                                <?php }?>
                            </tr>
                        <?php 
                        $bookNumber++;
                        }
                        ?>
                        </table>
                        <?php
                    }
                    else
                    {
                        ?> <div id="sorry-msg">Sorry! No books available at this moment! </div>
                    <?php }
                ?>
                <div id="addBookPopup">
                    <div id="popupContact">
                        <form action="#" id="form" method="post" name="form">
                            <h2>Add Book</h2>
                            <div id="close-button">X</div>
                            <hr>
                            <div><span>Name :</span> <input type="text" name="bookName" id="bookName" /></div>
                            <div><span>Type : </span>
                                <select name="bookTypes" id="bookTypes">
                                    <option value="">Select Type</option>
                                    <option value="Autobiography">Autobiography</option>
                                    <option value="Comedy">Comedy</option>
                                    <option value="Fiction">Fiction</option>
                                    <option value="Fitness">Fitness</option>
                                    <option value="Sports">Sports</option>
                                </select>
                            </div>
                            <div> <span>Total:</span><input type="number" name="totalBooks" id="totalBooks"/></div>
                            <div id="submitBook">Add</div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </body>
</html>