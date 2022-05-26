<?php
require_once("../vendor/dbconnect.php");
if (isset($_POST['submit-post']) && $_POST['submit-post'] == 'add') {
    $data['title'] = isset($_POST['title']) ? $_POST['title'] : null;
    $data['category_ids'] = isset($_POST['blogcat']) ? $_POST['blogcat'] : 0;
    $data['slug'] = isset($_POST['slug']) ? $_POST['slug'] : null;
    $data['postbody'] = isset($_POST['postbody']) ? htmlspecialchars($_POST['postbody']) : null;
    $data['status'] = 1;
    if ($data['title'] != null && $data['postbody'] != null) {
        $s = DB::insert("posts", $data);
        $id = DB::insertId();
        print_r($_FILES);
        if (isset($_FILES['files']) && $_FILES['files']['name'] != "") {
            $img = "../uploads/products/" . $_FILES['files']['name'];
            if (move_uploaded_file($_FILES["files"]["tmp_name"],  $img)) {
                DB::update("posts", ['image' => $img], "id=$id");
                header("Location:blog.php");
            }
        }
    } else {
        header("Location:addPost.php?err=1");
    }
} else {
    $data['title'] = isset($_POST['title']) ? $_POST['title'] : null;
    $data['category_ids'] = isset($_POST['blogcat']) ? $_POST['blogcat'] : 0;
    //$data['slug'] = isset($_POST['slug']) ? $_POST['slug'] : null;
    $data['postbody'] = isset($_POST['postbody']) ? htmlspecialchars($_POST['postbody']) : null;
    $id = isset($_POST['postid']) ? $_POST['postid'] : null;;
    if ($data['title'] != null && $data['postbody'] != null && $id != null) {
        $s = DB::update("posts", $data, "id=$id");


        if (isset($_FILES['files']) && $_FILES['files']['name'] != "") {
            $img = "../uploads/products/" . $_FILES['files']['name'];
            if (move_uploaded_file($_FILES["files"]["tmp_name"],  $img)) {
                DB::update("posts", ['image' => $img], "id=$id");
            }
        }
        header("Location:blog.php");
    } else {
        header("Location:addPost.php?err=1");
    }
}
