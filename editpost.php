<?php

if (isset($_GET['p_id'])) {
    $the_post_id = $_GET['p_id'];
}
//Select from DB and find all Posts query
$query = "SELECT * FROM posts WHERE post_id = {$the_post_id} /*LIMIT 3*/"; //Limits the displayed categories to 3
$select_posts_by_id = mysqli_query($connection, $query);
//***2*** 
//add an ordered list(li) with the include of our Variable
//we did created "$post_title" and with <a HREF it looks cleaner
while ($row = mysqli_fetch_assoc($select_posts_by_id)) {
    $post_id = $row['post_id'];
    $post_author = $row['post_author'];
    $post_title = $row['post_title'];
    $post_category_id = $row['post_category_id'];
    $post_status = $row['post_status'];
    $post_image = $row['post_image'];
    $post_content = $row['post_content'];
    $post_tags = $row['post_tags'];
    $post_comment_count = $row['post_comment_count'];
    $post_date = $row['post_date'];
}
if (isset($_POST['update_post'])) {

    $post_author = $_POST['post_author'];
    $post_title = $_POST['post_title'];
    $post_category_id = $_POST['post_category'];
    $post_status = $_POST['post_status'];
    $post_image = $_FILES['image']['name'];
    $post_image_temp = $_FILES['image']['tmp_name'];
    $post_content = $_POST['post_content'];
    $post_tags = $_POST['post_tags'];

    move_uploaded_file($post_image_temp, "../images/$post_image");
    //falls nichts im feld, definiere ich das Bild und rufe es auf im While Loop
    if (empty($post_image)) {
        $query = "SELECT * FROM posts WHERE post_id = $the_post_id ";
        $select_image = mysqli_query($connection, $query);

        while ($row = mysqli_fetch_array($select_image)) {
            $post_image = $row['post_image'];
        }
    }

    $query  = "UPDATE posts SET ";
    $query .= "post_title = '" . mysqli_real_escape_string($connection, $post_title) . "', ";
    $query .= "post_category_id = '{$post_category_id}', ";
    $query .= "post_date = now(), ";
    $query .= "post_author = '{$post_author}', ";
    $query .= "post_status = '{$post_status}', ";
    $query .= "post_tags = '{$post_tags}', ";
    $query .= "post_content = '{$post_content}', ";
    $query .= "post_image = '{$post_image}' ";
    $query .= "WHERE post_id = {$the_post_id} ";

    $update_post = mysqli_query($connection, $query);
    confirmQuery($update_post);
    //echo $query;
    //die();

    if (!$update_post) {
        die("QUERY FAILED" . mysqli_error($connection));
    }
}
?>
<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="title">Post Title</label>
        <input value="<?php echo $post_title; ?>" type="text" class="form-control" name="post_title">
    </div>
    <div class="form-group">
        <label for="categories">Categories</label>
        <select name="post_category" id="">
            <?php
            //***1***
            //Select from DB // find all categories ID query
            $query = "SELECT * FROM categories";
            $select_categories = mysqli_query($connection, $query);
            //confirm($select_categories);
            //***2*** 
            confirmQuery($select_categories);
            //add an ordered list(li) with the include of our Variable
            //we did created "$cat_title" and with <a HREF it looks cleaner




            /*while ($row = mysqli_fetch_assoc($select_categories)) {
                $cat_id = $row['cat_id'];
                $cat_title = $row['cat_title'];
                if ($cat_id == $post_category_id) {
                    echo "<option selected value='{$cat_id}'>{$cat_title}</option>";
                } else {
                    echo "<option value='{$cat_id}'>{$cat_title}</option>";
                }
            }


            
            */ ?>
        </select>
    </div>
    <div class="form-group">
        <label for="title">Post Author</label>
        <input value="<?php echo $post_author; ?>" type="text" class="form-control" name="post_author">
    </div>
    <div class="form-group">
        <label for="post_status">Post Status</label>
        <input value="<?php echo $post_status; ?>" type="text" class="form-control" name="post_status">
    </div>
    <div class="form-group">
        <img width="100" src="../images/<?php echo $post_image; ?>" alt="">
        <input type="file" name="image">
    </div>
    <div class="form-group">
        <label for="post_tags">Post Tags</label>
        <input value="<?php echo $post_tags; ?>" type="text" class="form-control" name="post_tags">
    </div>
    <div class="form-group">
        <label for="post_content">Post Content</label>
        <textarea name="post_content" id="" cols="30" rows="10" class="form-control"><?php echo $post_content; ?></textarea>
    </div>
    <div class="form-group">
        <input type="submit" class="btn btn-primary" name="update_post" value="Update Post">
    </div>
</form>