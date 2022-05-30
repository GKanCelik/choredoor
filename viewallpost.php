<table class="table table-hover table-bordered">
    <thead>
        <tr>
            <th>Id</th>
            <th>Author</th>
            <th>Title</th>
            <th>Category</th>
            <th>Status</th>
            <th>Image</th>
            <th>Tags</th>
            <th>Comments</th>
            <th>Date</th>
        </tr>
    </thead>
    <tbody>

        <?php
        //***1***
        //Select from DB // find all Posts query
        $query = "SELECT * FROM posts /*LIMIT 3*/"; //Limits the displayed categories to 3
        $select_posts = mysqli_query($connection, $query);
        //***2*** 
        //add an ordered list(li) with the include of our Variable
        //we did created "$post_title" and with <a HREF it looks cleaner
        while ($row = mysqli_fetch_assoc($select_posts)) {
            $post_id = $row['post_id'];
            $post_author = $row['post_author'];
            $post_title = $row['post_title'];
            $post_category_id = $row['post_category_id'];
            $post_status = $row['post_status'];
            $post_image = $row['post_image'];
            $post_tags = $row['post_tags'];
            $post_comment_count = $row['post_comment_count'];
            $post_date = $row['post_date'];
            echo "<tr>";
            echo "<td>{$post_id}</td>";
            echo "<td>{$post_author}</td>";
            echo "<td>{$post_title}</td>";
            //echo "<td>{$post_category_id}</td>";
            //this fixed somehow my problem with wrong table
            //cuted out so its not important...


            //area to display the dynamic selected Post Category ID
            $query = "SELECT * FROM categories WHERE cat_id = {$post_category_id} ";
            $select_categories_id = mysqli_query($connection, $query);
            while ($row = mysqli_fetch_assoc($select_categories_id)) {
                $cat_id = $row['cat_id'];
                $cat_title = $row['cat_title'];
                echo "<td>{$cat_title}</td>";
            }

            echo "<td>{$post_status}</td>";
            echo "<td><img width='100' src='../images/$post_image' alt='image'> </td>";
            echo "<td>{$post_tags}</td>";
            //echo "<td>$post_content </td>";
            echo "<td>{$post_comment_count}</td>";
            echo "<td>{$post_date}</td>";
            //DELETE POST AREA inclusiv EDIT AREA
            //commented out becouse we use divide Params function "&"
            //echo "<td> <a href='posts.php?edit_post={$post_id}'>Edit</a> </td>";

            //with Divided Params and redirect on Source
            echo "<td> <a href='posts.php?source=edit_post&p_id={$post_id}'>Edit</a> </td>";

            echo "<td> <a href='posts.php?delete={$post_id}'> Delete </a> </td>";
            echo "</tr>";
        } ?>
        <!--
        <td>10</td>
        <td>Gökhan Celik</td>
        <td>Bootstrap Framework</td>
        <td>Bootstrap</td>
        <td>Status</td>
        <td>Image</td>
        <td>Tags</td>
        <td>Comments</td>
        <td> php!!! // echo $post_date; php!!! </td>
    -->
    </tbody>
</table>

<?php
//DELETE POST AREA, here we catch it
if (isset($_GET['delete'])) {
    //now put it into an VAR
    $the_post_id = $_GET['delete'];
    //define query
    $query = "DELETE FROM posts WHERE post_id = {$the_post_id}";
    //execute query
    $delete_query = mysqli_query($connection, $query);
    //this cool header Functions redirects me back so it REFRESHES  :D
    header('Location: http://localhost:8080/cms/admin/posts.php');
}
?>