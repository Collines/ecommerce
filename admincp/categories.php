<?php
session_start(); // continue the current session
ob_start(); // prevent header issues
if(isset($_SESSION['Username'])) {
    $pageTitle = "Categories"; //TODO: lang("ADMIN_CATEGORIES");
    include "init.php";
    addNavBar();
    $do = isset($_GET['do']) ? $_GET['do'] : "manage";
    if($do == 'manage') {
        ?>
        <div class="container-fluid text-center">
            <h2 class='text-center mt-5 mb-5'>Manage Categories</h2>
            <div>
                <div class="card">
                    <h5 class="card-header"><i class="fas fa-list mr-2"></i>Categories</h5>
                    <div class="card-body">
                        <div class="table-responsive mt-5 mb-3">
                            <div class="text-right mr-5 mb-1">Sorting:
                                <a class="m-3 sorting <?php echo $_GET['sort'] == 'ASC' ? 'active' : '' ?>" href="?sort=ASC">Asc</a>
                                |
                                <a class="m-3 sorting <?php echo $_GET['sort'] == 'DESC' ? 'active' : '' ?>" href="?sort=DESC">Desc</a>
                            </div>
                            <table class="users-table table table-striped table-hover">
                                <tr>
                                    <td>CategoryID</td>
                                    <td>Category Name</td>
                                    <td>Description</td>
                                    <td>Visibility</td>
                                    <td>Ads Allowed</td>
                                    <td>Items Count</td>
                                    <td>Controls</td>
                                </tr>
                                <?php
                                $sort = "DESC";
                                $sortArray = array("ASC", "DESC");
                                if(isset($_GET['sort']) && in_array($_GET['sort'], $sortArray)) {
                                    $sort = $_GET['sort'];
                                }
                                $stmt = $con->prepare("SELECT ID, `name`, description, visibility, allowAds, itemscount FROM categories ORDER BY ordering $sort");
                                $stmt->execute();
                                $output = $stmt->fetchAll(); //Fetch all rows
                                if( count($output) > 0) {
                                    foreach($output as $row) {
                                        echo "<tr>";
                                        for($x=0; $x<(count($row)/2)+1; $x++) {
                                            if ($x == 3) {
                                                if($row[$x] == 1) {
                                                    echo "<td><span class='cat-visible'>Visible</span></td>";
                                                } else {
                                                    echo "<td><span class='cat-invisible'>Invisible</span></td>";
                                                }
                                            } else if($x == 4) {
                                                if($row[$x] == 1) {
                                                    echo "<td><span class='cat-visible'>Allowed</span></td>";
                                                } else {
                                                    echo "<td><span class='cat-invisible'>Not Allowed</span></td>";
                                                }
                                            } else if ($x > 5){
                                                echo "<td>
                                            <a href='categories.php?do=edit&CategoryID=" . $row[0] . "'>
                                                <button class='btn btn-primary mt-1 mb-1'><i class='far fa-edit mr-2'></i>Edit</button>
                                            </a>
                                            <a href='categories.php?do=delete&CategoryID=" . $row[0] . "'>
                                                <button class='btn btn-danger mt-1 mb-1'><i class='fas fa-minus-circle mr-2'></i>Delete</button>
                                            </a>
                                              </td>";
                                            } else {
                                                $data = $row[$x];
                                                echo "<td>" . $data . "</td>";
                                            }
                                        }
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='7'>No Categories</td></tr>";
                                }
                                ?>
                            </table>
                        </div>
                        <div class="row">
                            <div class="col-md-4 offset-md-4">
                                <a class='d-block' href='?do=add'><button class="btn btn-success"><i class="fas fa-plus mr-2"></i>Add Category</button></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<?php
    } else if ($do == 'add') { ?>

        <h2 class='text-center mt-5'>Add Category</h2>
        <form class="container mt-5" action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
            <div class="form-group row">
                <label for="catname" class="offset-sm-2 col-sm-2 col-form-label col-form-label-lg">Category Name</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control form-control-lg"  id="catname"  name="name" placeholder="New Category name" autocomplete="off" required="required">
                </div>
            </div>
            <div class="form-group row">
                <label for="desc" class="offset-sm-2 col-sm-2 col-form-label col-form-label-lg">Description</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control form-control-lg" id="desc" placeholder="Category Description" name="description"required="required"/>
                </div>
            </div>
            <div class="form-group row">
                <label for="ordering" class="offset-sm-2 col-sm-2 col-form-label col-form-label-lg">Ordering</label>
                <div class="col-sm-8">
                    <input type="number" class="form-control form-control-lg" id="ordering" name="ordering" placeholder="Ordering the Category"/>
                </div>
            </div>
            <div class="form-group row">
                <label for="visibility" class="offset-sm-2 col-sm-2 col-form-label col-form-label-lg">Visibility</label>
                <div class="col-sm-8" >
                    <select name="visibility" id="visibility" class="custom-select custom-select-lg">
                        <option value="1" selected>Visible</option>
                        <option value="0">Invisible</option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="ads" class="offset-sm-2 col-sm-2 col-form-label col-form-label-lg">Allow Ads</label>
                <div class="col-sm-8" >
                    <select name="allowads" id="ads" class="custom-select custom-select-lg">
                        <option value="1" selected>Yes</option>
                        <option value="0">No, Don't allow Ads</option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-8 offset-sm-4 mt-3">
                    <button type="submit" class="btn btn-primary btn-lg">Add Category</button>
                </div>
            </div>
        </form>
<?php
        if($_SERVER['REQUEST_METHOD'] == 'POST') { // if request method is post it will add the category to database from the same page otherwise it will only show the add form
            $catName = $_POST['name'];
            $catDesc = $_POST['description'];
            $catOrdering = isset($_POST['ordering']) ? $_POST['ordering'] : 0;
            $catVisibility = $_POST['visibility'];
            $allowAds = $_POST['allowads'];
            $formErrors = array();
            if(checkItem('name','categories',$catName) > 0) {
                $formErrors[] = "This <strong>Category Name</strong> already exists";
            }
            if(empty($catName)) {
                $formErrors[] = "<strong>Category Name</strong> field can't be empty";
            }
            if(empty($catDesc)) {
                $formErrors[] = "<strong>Category Description</strong> field can't be empty";
            }
            if($catOrdering < 0 || !is_numeric($catOrdering)) {
                $formErrors[] = "You can't write characters or negative numbers in <strong>Category Ordering</strong> field.";
            }
            foreach ($formErrors as $error) {
                outputMessage("error", $error);
            }
            if(empty($formErrors)) {
                $stmt = $con->prepare("INSERT INTO categories (`name`, `description`, `ordering`, `visibility`, `allowAds`) VALUES (?, ?, ?, ?, ?);");
                $stmt->execute(array($catName, $catDesc, $catOrdering, $catVisibility, $allowAds));
                outputMessage("success","Category [" . $catName . "] added successfully!" );
            }
        }
    } else if ($do == 'edit') { ?>
        <h2 class="text-center mt-5">Edit Category</h2>
        <?php
        if(isset($_GET['CategoryID']) && is_numeric($_GET['CategoryID'])) {
            if($_SERVER['REQUEST_METHOD'] == 'POST') {
                $catID = $_POST['CatID'];
                $catName = $_POST['catName'];
                $catDesc = $_POST['catDesc'];
                $catOrdering = $_POST['catOrdering'];
                $catVisibility = $_POST['visibility'];
                $catAds = $_POST['allowads'];
                $formErrors = array();
                if(empty($catName)) {
                    $formErrors[] = "<strong>Category Name</strong> field can't be empty";
                }
                if(empty($catDesc)) {
                    $formErrors[] = "<strong>Description</strong> field can't be empty";
                }
                if($catOrdering < 0) {
                    $formErrors[] = "<strong>Ordering</strong> Should be > 0";
                }

                if(!is_numeric($catOrdering)) {
                    $formErrors[] = "Can't write text in <strong>Ordering</strong> Field";
                }

                foreach ($formErrors as $error) {
                    outputMessage("error", $error);
                }
                if(empty($formErrors)) {
                    $stmt = $con->prepare("UPDATE categories SET `name` = ? , description = ? , ordering = ? , visibility = ?, allowAds = ? WHERE ID = ?;");
                    $stmt->execute(array($catName, $catDesc, $catOrdering, $catVisibility, $catAds, $catID));
                    redirectPage("Updated Successfully, [" . $stmt->rowCount() . "] rows affected","success", "", 0.5, false);
                }
            }
            $isExist = checkItem("ID",'categories',$_GET['CategoryID']);
            if($isExist) {
                $stmt = $con->prepare("SELECT `name`, description, ordering, visibility, allowAds FROM categories WHERE ID = ?;");
                $stmt->execute(array($_GET['CategoryID']));
                if ($stmt->rowCount() > 0) { // to make sure we get a result from Database
                    $output = $stmt->fetch();
                    $catID = $_GET['CategoryID'];
                    $catName = $output[0];
                    $catDesc = $output[1];
                    $catOrdering = $output[2];
                    $catVisibility = $output[3];
                    $catAds = $output[4];
                    ?>
                    <form class="container mt-5" action="" method="post">
                        <input type="hidden" name="CatID" value="<?php echo $catID ?>"/>
                        <div class="form-group row">
                            <label for="username"
                                   class="offset-sm-2 col-sm-2 col-form-label col-form-label-lg">Category Name</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control form-control-lg" value="<?php echo $catName ?>" name="catName"
                                       autocomplete="off" required="required">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="catdesc"
                                   class="offset-sm-2 col-sm-2 col-form-label col-form-label-lg">Description</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control form-control-lg" id="catdesc"
                                       value="<?php echo $catDesc ?>" name="catDesc" required="required"/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="ordering" class="offset-sm-2 col-sm-2 col-form-label col-form-label-lg">Ordering</label>
                            <div class="col-sm-8">
                                <input type="number" class="form-control form-control-lg" id="ordering"
                                       name="catOrdering" value="<?php echo $catOrdering ?>" autocomplete="off"/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="visibility" class="offset-sm-2 col-sm-2 col-form-label col-form-label-lg">Visibility</label>
                            <div class="col-sm-8" >
                                <select name="visibility" id="visibility" class="custom-select custom-select-lg">
                                    <?php
                                        if($catVisibility == 1) {
                                            echo "<option value='1' selected>Visible</option>
                                                    <option value='0'>Invisible</option>";
                                        } else {
                                            echo "<option value='1'>Visible</option>
                                                    <option value='0' selected>Invisible</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="ads" class="offset-sm-2 col-sm-2 col-form-label col-form-label-lg">Allow Ads</label>
                            <div class="col-sm-8" >
                                <select name="allowads" id="ads" class="custom-select custom-select-lg">
                                    <?php
                                        if($catAds == 1) {
                                            echo "<option value='1' selected>Yes</option>
                                                    <option value='0'>No</option>";
                                        } else {
                                            echo "<option value='1'>Yes</option>
                                                    <option value='0' selected>No</option>";
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
                redirectPage("Category Doesn't Exist", "error", 'categories.php',1, false);
            }
        } else {
            redirectPage('Redirecting...','error', 'categories.php', 1.5,false);
        }

    } else if ($do == 'update') {

    } else if ($do == 'delete') {
        if(isset($_GET['CategoryID']) && is_numeric($_GET['CategoryID'])) {
            if(isset($_POST['CategoryID'])) {
                $stmt = $con->prepare('DELETE FROM categories WHERE ID = ?;');
                $stmt->execute(array($_POST['CategoryID']));
                redirectPage("Category Deleted Successfully", "success", "categories.php", 1);
            } else {
                $isExist = checkItem('id', 'categories', $_GET['CategoryID']);
                if($isExist) {
                    $stmt2 = $con->prepare('SELECT `name` FROM categories WHERE ID = ?;');
                    $stmt2->execute(array($_GET['CategoryID']));
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
                                        <p>Are you sure you want to delete [ <?php echo $output[0]; ?> ] Category? </p>
                                    </div>
                                    <div class="modal-footer">
                                        <a href="categories.php">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close
                                            </button>
                                        </a>
                                        <form method="post" action="">
                                            <input type="hidden" name="CategoryID" value="<?php echo $_GET['CategoryID'] ?>"/>
                                            <input type="submit" class="btn btn-danger" value="Delete"/>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                } else {
                    redirectPage("User doesn't exist", "error", 'members.php');
                }
            }
        } else {
            redirectPage("You can't access this page directly", 'error', 'members.php');
        }
    }

    include $tpl . "footer.inc";

} else {
    redirectPage("You can't browse this page without logging in", 'error', 'index.php', 2);
}


ob_end_flush();