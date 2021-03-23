<?php
/**
 * Created by PhpStorm.
 * User: eng-nanna
 * Date: 3/10/2018
 * Time: 1:22 PM
 */
function is_post_request() {
    return $_SERVER['REQUEST_METHOD'] == 'POST';
}

function is_get_request() {
    return $_SERVER['REQUEST_METHOD'] == 'GET';
}

function display_errors($errors=array()) {
    $output = '';
    if(!empty($errors)) {
        $output .= "<div class=errors>";
        $output .= "يرجى تصحيح الأخطاء التالية :";
        $output .= "<ul>";
        foreach($errors as $error) {
            $output .= "<li>" . htmlspecialchars($error) . "</li>";
        }
        $output .= "</ul>";
        $output .= "</div>";
    }
    return $output;
}

// is_blank('abcd')
// * validate data presence
// * uses trim() so empty spaces don't count
// * uses === to avoid false positives
// * better than empty() which considers "0" to be empty
function is_blank($value) {
    return !isset($value) || trim($value) === '';
}

// Performs all actions necessary to log in an admin
function log_in_admin($admin) {
    // Regenerating the ID protects the admin from session fixation.
    session_regenerate_id();
    $_SESSION['admin_id'] = $admin['admin_id'];
    $_SESSION['last_login'] = time();
    $_SESSION['username'] = $admin['username'];
    return true;
}

function is_logged_in() {
    // Having a admin_id in the session serves a dual-purpose:
    // - Its presence indicates the admin is logged in.
    // - Its value tells which admin for looking up their record.
    return isset($_SESSION['admin_id']);
}

function require_login() {
    if(!is_logged_in()) {
        header("location: index.php");
        exit();
    } else {
        // Do nothing, let the rest of the page proceed
    }
}

// has_length_greater_than('abcd', 3)
// * validate string length
// * spaces count towards length
// * use trim() if spaces should not count
function has_length_greater_than($value, $min) {
    $length = strlen($value);
    return $length > $min;
}

// has_length_less_than('abcd', 5)
// * validate string length
// * spaces count towards length
// * use trim() if spaces should not count
function has_length_less_than($value, $max) {
    $length = strlen($value);
    return $length < $max;
}

// has_length_exactly('abcd', 4)
// * validate string length
// * spaces count towards length
// * use trim() if spaces should not count
function has_length_exactly($value, $exact) {
    $length = strlen($value);
    return $length == $exact;
}

// has_length('abcd', ['min' => 3, 'max' => 5])
// * validate string length
// * combines functions_greater_than, _less_than, _exactly
// * spaces count towards length
// * use trim() if spaces should not count
function has_length($value, $options) {
    if(isset($options['min']) && !has_length_greater_than($value, $options['min'] - 1)) {
        return false;
    } elseif(isset($options['max']) && !has_length_less_than($value, $options['max'] + 1)) {
        return false;
    } elseif(isset($options['exact']) && !has_length_exactly($value, $options['exact'])) {
        return false;
    } else {
        return true;
    }
}

function has_unique_username($username,$current_id="0"){
    global $db;
    $username= db_escape($db,$username);
    $current_id= db_escape($db,$current_id);

    $sql = "SELECT * FROM admins WHERE username='$username' AND admin_id != '$current_id'";

    $admin_set = mysqli_query($db,$sql);
    $admin_count = mysqli_num_rows($admin_set);
    mysqli_free_result($admin_set);

    return $admin_count === 0;
}

function has_unique_name($league_name,$league_year){
    global $db;
    $league_name= db_escape($db,$league_name);
    $league_year= db_escape($db,$league_year);

    $sql = "SELECT * FROM leagues WHERE league_name='$league_name' AND league_year = '$league_year'";

    $league_set = mysqli_query($db,$sql);
    $league_count = mysqli_num_rows($league_set);
    mysqli_free_result($league_set);

    return $league_count === 0;
}

function has_unique_team($team_name){
    global $db;
    $team_name= db_escape($db,$team_name);

    $sql = "SELECT * FROM teams WHERE team_name='$team_name' ";

    $team_set = mysqli_query($db,$sql);
    $team_count = mysqli_num_rows($team_set);
    mysqli_free_result($team_set);

    return $team_count === 0;
}

function has_unique_categ($category){
    global $db;
    $category= db_escape($db,$category);

    $sql = "SELECT * FROM categories WHERE category='$category' ";

    $categ_set = mysqli_query($db,$sql);
    $categ_count = mysqli_num_rows($categ_set);
    mysqli_free_result($categ_set);

    return $categ_count === 0;
}

function has_unique_video($video){
    global $db;
    $video= db_escape($db,$video);

    $sql = "SELECT * FROM videos WHERE video_title='$video' ";

    $video_set = mysqli_query($db,$sql);
    $video_count = mysqli_num_rows($video_set);
    mysqli_free_result($video_set);

    return $video_count === 0;
}
