<?php
session_start();
ob_start();

if(isset($_SESSION['Username'])) {
    $pageTitle = "Items"; //TODO: lang("ADMIN_ITEMS");
    include "init.php";
    addNavBar();
    $do = isset($_GET['do']) ? $_GET['do'] : "manage";
    if($do == 'manage') { ?>
        <h2 class='text-center mt-5'>Manage Items</h2>
        <div class="container-fluid members-table text-center">
            <div class="table-responsive mt-5 mb-3">
                <table class="users-table table table-striped table-hover">
                    <tr>
                        <td>ID</td>
                        <td>Name</td>
                        <td>Price</td>
                        <td>Brand</td>
                        <td>Category</td>
                        <td>Added by</td>
                        <td>Add Date</td>
                        <td>Controls</td>
                    </tr>
                    <?php
                    $stmt = $con->prepare("SELECT items.* , categories.name AS category_name, users.username FROM items
                                            INNER JOIN categories ON categories.ID = items.Cat_ID
                                            INNER JOIN users ON users.userID = items.Member_ID");
                    $stmt->execute();
                    $result = $stmt->fetchAll(); //Fetch all rows
                    if( count($result) > 0) {
                        foreach($result as $row) {
                            echo "<tr>";
                            echo "<td>" . $row['itemID'] . "</td>";
                            echo "<td>" . $row['Name'] . "</td>";
                            echo "<td>" . "$" . $row['Price'] . "</td>";
                            echo "<td>" . $row['Brand'] . "</td>";
                            echo "<td>" . $row['category_name'] . "</td>";
                            echo "<td>" . $row['username'] . "</td>";
                            echo "<td>" . $row['AddDate'] . "</td>";
                            echo "<td>
                            <a href='items.php?do=edit&ItemID=" . $row[0] . "'>
                                <button class='btn btn-primary mt-1 mb-1'><i class='far fa-edit mr-2'></i>Edit</button>
                            </a>
                            <a href='items.php?do=delete&ItemID=" . $row[0] . "'>
                                <button class='btn btn-danger mt-1 mb-1'><i class='fas fa-minus-circle mr-2'></i>Delete</button>
                            </a>
                              </td>";
                            echo "<tr>";
                        }

                    } else {
                        echo "<tr><td colspan='8'>No Items</td></tr>";
                    }
                    ?>
                </table>
            </div>
            <div class="row">
                <div class="col-md-4 offset-md-4">
                    <a class='d-block mb-5' href='?do=add'><button class="btn btn-success"><i class="fas fa-plus mr-2"></i>Add Item</button></a>
                </div>
            </div>
        </div>
<?php
    } else if ($do == 'add') { ?>
        <h2 class='text-center mt-5'>Add Item</h2>
        <form class="container mt-5" action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
            <div class="form-group row">
                <label for="itemname" class="offset-sm-2 col-sm-2 col-form-label col-form-label-lg">Item Name</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control form-control-lg"  id="itemname"  name="name" placeholder="Item name" required="required">
                </div>
            </div>
            <div class="form-group row">
                <label for="itemdescription" class="offset-sm-2 col-sm-2 col-form-label col-form-label-lg">Item Description</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control form-control-lg" id="itemdescription" placeholder="Item Description" name="description"required="required"/>
                </div>
            </div>
            <div class="form-group row">
                <label for="Price" class="offset-sm-2 col-sm-2 col-form-label col-form-label-lg">Price</label>
                <div class="col-sm-8">
                    <input type="number" class="form-control form-control-lg" id="Price" placeholder="Item Price" name="price" required="required"/>
                </div>
            </div>
            <div class="form-group row">
                <label for="brand" class="offset-sm-2 col-sm-2 col-form-label col-form-label-lg">Brand</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control form-control-lg" id="brand" placeholder="Brand (e.g Samsung, Apple)" name="brand" required="required"/>
                </div>
            </div>
            <div class="form-group row">
                <label for="status" class="offset-sm-2 col-sm-2 col-form-label col-form-label-lg">Item Status</label>
                <div class="col-sm-8" >
                    <select name="status" id="status" class="" required="required">
                        <option value='3' selected>New</option>
                        <option value="2">Like New</option>
                        <option value="1">Used</option>
                        <option value="0">Very Used</option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="member" class="offset-sm-2 col-sm-2 col-form-label col-form-label-lg">Posted By</label>
                <div class="col-sm-8" >
                    <select name="member" id="member" class="" required="required">
                        <option value='0' selected>...</option>
                        <?php
                            $stmt = $con->prepare('SELECT userid, username FROM users');
                            $stmt->execute();
                            $result = $stmt->fetchAll();
                            foreach ($result as $row ){
                                echo "<option value='" . $row[0] . "'>" . $row[1] . "</option>";
                            }
                        ?>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="category" class="offset-sm-2 col-sm-2 col-form-label col-form-label-lg">Item Category</label>
                <div class="col-sm-8" >
                    <select name="category" id="category" class="" required="required">
                        <option value='0' selected>...</option>
                        <?php
                        $stmt = $con->prepare('SELECT ID, `name` FROM categories');
                        $stmt->execute();
                        $result = $stmt->fetchAll();
                        foreach ($result as $row ){
                            echo "<option value='" . $row[0] . "'>" . $row[1] . "</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-8 offset-sm-4 mt-3">
                    <button type="submit" class="btn btn-primary btn-lg">Add Item</button>
                </div>
            </div>
        </form>
<?php
        if($_SERVER['REQUEST_METHOD'] == 'POST') { // if request method is post it will add the item to database from the same page otherwise it will only show the add form
            $itemName = $_POST['name'];
            $itemDesc = $_POST['description'];
            $itemPrice = $_POST['price'];
            $itemBrand = $_POST['brand'];
            $itemStatus = $_POST['status'];
            $posterID = $_POST['member'];
            $itemCategory = $_POST['category'];
            $formErrors = array();
            if(empty($itemName)) {
                $formErrors[] = "<strong>Item Name</strong> field can't be empty";
            }
            if(empty($itemDesc)) {
                $formErrors[] = "<strong>Item Description</strong> field can't be empty";
            }
            if($itemPrice < 0 || !is_numeric($itemPrice)) {
                $formErrors[] = "You can't write characters or negative numbers in <strong>Price</strong> field.";
            }
            if($itemCategory == 0) {
                $formErrors[] = "You Must Select <strong>Item Category</strong>";
            }
            if($posterID == 0) {
                $formErrors[] = "You Must Select <strong>Posted By</strong>";
            }
            foreach ($formErrors as $error) {
                outputMessage("error", $error);
            }
            if(empty($formErrors)) {
                $stmt = $con->prepare("INSERT INTO items (`name`, `description`, `price`, `Brand`, `Status`, `Cat_ID`, `Member_ID`, `AddDate`) VALUES (?, ?, ?, ?, ?, ?, ?, NOW());");
                $stmt->execute(array($itemName, $itemDesc, $itemPrice, $itemBrand, $itemStatus, $itemCategory, $posterID));
                outputMessage("success","Item [ <strong>" . $itemName . "</strong> ] added successfully!" );
            }
        }

    } else if ($do == 'edit') { ?>
        <h2 class="text-center mt-5">Edit Item</h2>
        <?php

        if($_SERVER['REQUEST_METHOD'] == 'POST') { // if request method is post it will add the item to database from the same page otherwise it will only show the add form
            $itemName = $_POST['itemname'];
            $itemDesc = $_POST['itemdesc'];
            $itemPrice = $_POST['price'];
            $itemBrand = $_POST['brand'];
            $itemStatus = $_POST['status'];
            $itemCategory = $_POST['category'];
            $formErrors = array();
            if(empty($itemName)) {
                $formErrors[] = "<strong>Item Name</strong> field can't be empty";
            }
            if(empty($itemDesc)) {
                $formErrors[] = "<strong>Item Description</strong> field can't be empty";
            }
            if($itemPrice < 0 || !is_numeric($itemPrice)) {
                $formErrors[] = "You can't write characters or negative numbers in <strong>Price</strong> field.";
            }
            if($itemCategory == 0) {
                $formErrors[] = "You Must Select <strong>Item Category</strong>";
            }
            foreach ($formErrors as $error) {
                outputMessage("error", $error);
            }
            if(empty($formErrors)) {
                $stmt = $con->prepare("UPDATE items SET `name` = ?,  `description` = ?, `price` = ?, `Brand` = ?, `Status` = ?, `Cat_ID` = ?, `AddDate` = NOW();");
                $stmt->execute(array($itemName, $itemDesc, $itemPrice, $itemBrand, $itemStatus, $itemCategory));
                outputMessage("success","Item [ <strong>" . $itemName . "</strong> ] Edited successfully!" );
            }
        }

        if(isset($_GET['ItemID']) && is_numeric($_GET['ItemID'])) {
            $isExist = checkItem("itemID",'items',$_GET['ItemID']);
            if($isExist) {
                $stmt = $con->prepare("SELECT `name`, description, price, brand, status, Cat_ID, Member_ID FROM items WHERE itemID = ?;");
                $stmt->execute(array($_GET['ItemID']));
                if ($stmt->rowCount() > 0) { // to make sure we get a result from Database
                    $output = $stmt->fetch();
                    $itemID = $_GET['ItemID'];
                    $itemName = $output[0];
                    $itemDesc = $output[1];
                    $itemPrice = $output[2];
                    $itemBrand = $output[3];
                    $itemStatus = $output[4];
                    $itemCategory = $output[5];
                    $posterID = $output[6];
                    ?>
                    <form class="container mt-5" action="" method="post">
                        <input type="hidden" name="itemid" value="<?php echo $itemID ?>"/>
                        <div class="form-group row">
                            <label for="itemname"
                                   class="offset-sm-2 col-sm-2 col-form-label col-form-label-lg">Item Name</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control form-control-lg" value="<?php echo $itemName ?>" name="itemname"
                                      id="itemname" autocomplete="off" required="required">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="itemdesc"
                                   class="offset-sm-2 col-sm-2 col-form-label col-form-label-lg">Description</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control form-control-lg" id="itemdesc"
                                       value="<?php echo $itemDesc ?>" name="itemdesc" required="required"/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="price" class="offset-sm-2 col-sm-2 col-form-label col-form-label-lg">Price</label>
                            <div class="col-sm-8">
                                <input type="number" class="form-control form-control-lg" id="price" required="required"
                                       name="price" value="<?php echo $itemPrice ?>" autocomplete="off"/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="brand" class="offset-sm-2 col-sm-2 col-form-label col-form-label-lg">Brand</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control form-control-lg" id="brand" required="required"
                                       name="brand" value="<?php echo $itemBrand ?>" autocomplete="off"/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="status" class="offset-sm-2 col-sm-2 col-form-label col-form-label-lg">Item Status</label>
                            <div class="col-sm-8" >
                                <select name="status" id="status" class="" required="required">
                                    <option value='3' <?php echo $itemStatus == 3 ? "selected" : ""; ?> >New</option>
                                    <option value="2" <?php echo $itemStatus == 2 ? "selected" : ""; ?>>Like New</option>
                                    <option value="1" <?php echo $itemStatus == 1 ? "selected" : ""; ?>>Used</option>
                                    <option value="0" <?php echo $itemStatus == 0 ? "selected" : ""; ?>>Very Used</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="category" class="offset-sm-2 col-sm-2 col-form-label col-form-label-lg">Item Category</label>
                            <div class="col-sm-8" >
                                <select name="category" id="category" class="" required="required">
                                    <?php
                                    $stmt = $con->prepare('SELECT ID, `name` FROM categories');
                                    $stmt->execute();
                                    $result = $stmt->fetchAll();
                                    foreach ($result as $row ){ ?>
                                        <option value="<?php echo $row[0] ?>" <?php echo $itemCategory == $row[0] ? "selected" : "" ?> > <?php echo $row[1] ?> </option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-8 offset-sm-4 mt-3">
                                <button type="submit" class="btn btn-primary btn-lg">Edit</button>
                            </div>
                        </div>
                    </form>
                    <?php
                }
            } else {
                redirectPage("Item Doesn't Exist", "error", 'items.php',1, false);
            }
        } else {
            redirectPage('Redirecting...','error', 'items.php', 1.5,false);
        }

    } else if ($do == 'delete') {
        if(isset($_GET['ItemID']) && is_numeric($_GET['ItemID'])) {
            if(isset($_POST['ItemID'])) {
                $stmt = $con->prepare('DELETE FROM items WHERE itemID = ?;');
                $stmt->execute(array($_POST['ItemID']));
                redirectPage("Item Deleted Successfully", "success", "items.php", 1);
            } else {
                $isExist = checkItem('itemid', 'items', $_GET['ItemID']);
                if($isExist) {
                    $stmt2 = $con->prepare('SELECT `name` FROM items WHERE itemID = ?;');
                    $stmt2->execute(array($_GET['ItemID']));
                    $output = $stmt2->fetch();
                    if($stmt2->rowCount()) {
                        ?>
                        <div class="delete-confirmation modal" tabindex="-1" role="dialog">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Delete Confirmation</h5>
                                    </div>
                                    <div class="modal-body">
                                        <p>Are you sure you want to delete [ <?php echo $output[0]; ?> ] Item? </p>
                                    </div>
                                    <div class="modal-footer">
                                        <a href="items.php">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close
                                            </button>
                                        </a>
                                        <form method="post" action="">
                                            <input type="hidden" name="ItemID" value="<?php echo $_GET['ItemID'] ?>"/>
                                            <input type="submit" class="btn btn-danger" value="Delete"/>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                } else {
                    redirectPage("Item doesn't exist", "error", 'items.php');
                }
            }
        } else {
            redirectPage("You can't access this page directly", 'error', 'items.php');
        }

    } else if ($do == 'approve') {

    }

    include $tpl . 'footer.inc';

} else {
    redirectPage("You can't browse this page without logging in", 'error', 'index.php', 2);
}

ob_end_flush();