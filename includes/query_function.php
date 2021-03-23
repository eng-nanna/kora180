<?php
/**
 * Created by PhpStorm.
 * User: eng-nanna
 * Date: 3/10/2018
 * Time: 1:35 PM
 */
function find_all_admins(){
    global $db;

    $sql = "SELECT * FROM admins ORDER BY username ASC ";
    $result = mysqli_query($db,$sql);
    confirm_result_set($result);
    return $result;
}

function validate_admin($admin,$options=[]) {
    $password_required = $options['password_required'] ?? true;

    $errors = [];

    // username
    if(is_blank($admin['username'])) {
        $errors[] = "املأ خانة اسم المستخدم";
    }elseif(!has_length($admin['username'], ['min' => 4, 'max' => 25])) {
        $errors[] = "اسم المستخدم يجب أن لا يقل عن 4 احرف";
    }elseif (!has_unique_username($admin['username'],$admin['id']??'0')){
        $errors[] = "هذا الاسم غير متاح. يرجى ادخال اسم آخر";
    }

    if ($password_required){
        // Password
        if(is_blank($admin['password'])) {
            $errors[] = "يجب ملأ خانة كلمة المرور";
        }elseif(!has_length($admin['password'], ['min' => 8])) {
            $errors[] = "كلمة المرور يجب أن لا تقل عن 8 أحرف";
        }elseif (!preg_match('/[A-Z]/',$admin['password'])){
            $errors[] = "كلمة المرور يجب أن تحتوي على الأقل حرف احد في حالة ال uppercase";
        }elseif (!preg_match('/[a-z]/',$admin['password'])){
            $errors[] = "كلمة المرور يجب أن تحتوي على الأقل حرف احد في حالة ال lowercase";
        }elseif (!preg_match('/[0-9]/',$admin['password'])){
            $errors[] = "كلمة المرور يجب أن تحتوي على رقم واحد على الأقل";
        }elseif (!preg_match('/[^A-Za-z0-9\s]/',$admin['password'])){
            $errors[] = "كلمة المرور يجب أن تحتوي على رمز واحد على الأقل";
        }
    }

    return $errors;
}

function insert_admin($admin){
    global $db;

    $errors = validate_admin($admin);
    if(!empty($errors)){
        return $errors;
    }

    $admin['username']= db_escape($db,$admin['username']);
    $admin['password']= password_hash(db_escape($db,$admin['password']), PASSWORD_DEFAULT);

    $sql = "INSERT INTO admins (username,password)
            VALUES('$admin[username]','$admin[password]')";
    $result = mysqli_query($db,$sql);
    if($result){
        return true;
    }else{
        echo mysqli_error($db);
        db_disconnect($db);
        exit();
    }
}

function update_admin($admin){
    global $db;

    $password_sent = !is_blank($admin['password']);

    $errors = validate_admin($admin,['password_required' => $password_sent]);
    if(!empty($errors)){
        return $errors;
    }

    $admin['id']= db_escape($db,$admin['id']);
    $admin['username']= db_escape($db,$admin['username']);
    if ($password_sent){
        $admin['password']= password_hash(db_escape($db,$admin['password']), PASSWORD_DEFAULT);

        $sql = "UPDATE admins 
            SET username='$admin[username]' ,password = '$admin[password]'
            WHERE admin_id = '$admin[id]'
            LIMIT 1";
    }else{
        $sql = "UPDATE admins 
            SET username='$admin[username]'
            WHERE admin_id = '$admin[id]'
            LIMIT 1";
    }
    $result = mysqli_query($db,$sql);
    if($result){
        return true;
    }else{
        echo mysqli_error($db);
        db_disconnect($db);
        exit();
    }
}

function delete_admin($id) {
    global $db;
    $id= db_escape($db,$id);

    $sql = "DELETE FROM admins WHERE admin_id='$id' LIMIT 1";
    $result = mysqli_query($db,$sql);
    if ($result){
        return true;
    }else{
        echo mysqli_error($db);
        db_disconnect($db);
        exit();
    }
}


function find_all_leagues($options=[]){
    global $db;
    $year = $options['year'] ?? false;

    $sql = "SELECT * FROM leagues  ";
    if ($year){
        $sql .= "WHERE league_year = '$year' ";
    }
    $sql .= "ORDER BY league_year DESC , league_id ASC";
    $result = mysqli_query($db,$sql);
    confirm_result_set($result);
    return $result;
}

function insert_league($league){
    global $db;

    $errors = validate_league($league);
    if(!empty($errors)){
        return $errors;
    }

    $league['league_name']= db_escape($db,$league['league_name']);
    $league['league_year']= db_escape($db,$league['league_year']);
    $league['league_logo']= db_escape($db,$league['league_logo']);

    $sql = "INSERT INTO leagues (league_name,league_logo,league_year)
            VALUES('$league[league_name]','$league[league_logo]','$league[league_year]')";
    $result = mysqli_query($db,$sql);
    if($result){
        return true;
    }else{
        echo mysqli_error($db);
        db_disconnect($db);
        exit();
    }
}

function validate_league($league,$options=[]) {

    $errors = [];

    // league_name
    if(is_blank($league['league_name'])) {
        $errors[] = "يجب ملأ خانة اسم الدوري";
    }elseif(!has_length($league['league_name'], ['min' => 4, 'max' => 255])) {
        $errors[] = "الاسم يجد أن يكون بين 4 الى 255 حرف";
    }elseif (!has_unique_name($league['league_name'],$league['league_year'])){
        $errors[] = "هذا الاسم غير متاح. يرجى ادخال اسم آخر";
    }

    return $errors;
}

function update_league($league){
    global $db;

    /*$errors = validate_league($league);
    if(!empty($errors)){
        return $errors;
    }*/

    $league['id']= db_escape($db,$league['id']);
    $league['league_name']= db_escape($db,$league['league_name']);
    $league['league_year']= db_escape($db,$league['league_year']);
    $league['league_logo']= db_escape($db,$league['league_logo']);

    $sql = "UPDATE leagues 
            SET league_name='$league[league_name]', league_year='$league[league_year]', league_logo = '$league[league_logo]'
            WHERE league_id = '$league[id]'
            LIMIT 1";
    $result = mysqli_query($db,$sql);
    if($result){
        return true;
    }else{
        echo mysqli_error($db);
        db_disconnect($db);
        exit();
    }
}

function delete_league($id) {
    global $db;
    $id= db_escape($db,$id);

    $sql = "DELETE FROM leagues WHERE league_id='$id' LIMIT 1";
    $result = mysqli_query($db,$sql);
    if ($result){
        return true;
    }else{
        echo mysqli_error($db);
        db_disconnect($db);
        exit();
    }
}


function find_all_teams($options=[]){
    global $db;

    $team_id = $options['team_id'] ?? false;

    $sql = "SELECT * FROM teams ";
    if ($team_id){
        $sql .= "WHERE team_id = '$team_id' ";
    }
    $sql .= "ORDER BY team_name ASC ";
    $result = mysqli_query($db,$sql);
    confirm_result_set($result);
    return $result;
}

function insert_team($team){
    global $db;

    $errors = validate_team($team);
    if(!empty($errors)){
        return $errors;
    }

    $team['team_name']= db_escape($db,$team['team_name']);
    $team['team_logo']= db_escape($db,$team['team_logo']);

    $sql = "INSERT INTO teams (team_name,team_logo)
            VALUES('$team[team_name]','$team[team_logo]')";
    $result = mysqli_query($db,$sql);
    if($result){
        return true;
    }else{
        echo mysqli_error($db);
        db_disconnect($db);
        exit();
    }
}

function validate_team($team,$options=[]) {

    $errors = [];

    // league_name
    if(is_blank($team['team_name'])) {
        $errors[] = "يجب ملأ خانة اسم الفريق";
    }elseif(!has_length($team['team_name'], ['min' => 4, 'max' => 255])) {
        $errors[] = "الاسم يجد أن يكون بين 4 الى 255 حرف";
    }elseif (!has_unique_team($team['team_name'],$team['team_id']??'0')){
        $errors[] = "هذا الاسم غير متاح. يرجى ادخال اسم آخر";
    }

    return $errors;
}

function update_team($team){
    global $db;

    /*$errors = validate_team($team);
    if(!empty($errors)){
        return $errors;
    }*/

    $team['id']= db_escape($db,$team['id']);
    $team['team_name']= db_escape($db,$team['team_name']);
    $team['team_logo']= db_escape($db,$team['team_logo']);

    $sql = "UPDATE teams 
            SET team_name='$team[team_name]', team_logo = '$team[team_logo]'
            WHERE team_id = '$team[id]'
            LIMIT 1";
    $result = mysqli_query($db,$sql);
    if($result){
        return true;
    }else{
        echo mysqli_error($db);
        db_disconnect($db);
        exit();
    }
}

function delete_team($id) {
    global $db;
    $id= db_escape($db,$id);

    $sql = "DELETE FROM teams WHERE team_id='$id' LIMIT 1";
    $result = mysqli_query($db,$sql);
    if ($result){
        return true;
    }else{
        echo mysqli_error($db);
        db_disconnect($db);
        exit();
    }
}


function find_all_news($options=[]){
    global $db;

    $limit = $options['limit'] ?? false;

    $sql = "SELECT * FROM news ORDER BY publish_date DESC, news_id DESC ";
    if ($limit){
        $sql .= "LIMIT {$limit}";
    }
    $result = mysqli_query($db,$sql);
    confirm_result_set($result);
    return $result;
}

function find_news_by_id($id,$options=[]){
    global $db;
    $id= db_escape($db,$id);

    $sql = "SELECT * FROM news WHERE news_id = '$id' ";
    $result = mysqli_query($db,$sql);
    confirm_result_set($result);
    $news = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $news;
}

function insert_news($news){
    global $db;

    $errors = validate_news($news);
    if(!empty($errors)){
        return $errors;
    }

    $news['title']= db_escape($db,$news['title']);
    $news['details'] = db_escape($db,$news['details']);
    $news['img'] = db_escape($db,$news['img']);

    $sql = "INSERT INTO news (title,publish_date,img,details)
            VALUES('$news[title]','$news[publish_date]','$news[img]','$news[details]')";
    $result = mysqli_query($db,$sql);
    if($result){
        return true;
    }else{
        echo mysqli_error($db);
        db_disconnect($db);
        exit();
    }
}

function validate_news($news,$options=[]) {

    $errors = [];

    // news_title
    if(is_blank($news['title'])) {
        $errors[] = "يجب ملأ خانة عنوان الخبر";
    }elseif(!has_length($news['title'], ['min' => 6, 'max' => 255])) {
        $errors[] = "العنوان يجد أن يكون بين 6 الى 255 حرف";
    }

    // news_content
    if(is_blank($news['details'])) {
        $errors[] = "يجب ملأ خانة محتوى الخبر";
    }



    return $errors;
}

function update_news($news){
    global $db;

    $errors = validate_news($news);
    if(!empty($errors)){
        return $errors;
    }

    $news['id']= db_escape($db,$news['id']);
    $news['title']= db_escape($db,$news['title']);
    $news['details'] = db_escape($db,$news['details']);
    $news['img'] = db_escape($db,$news['img']);

    $sql = "UPDATE news 
            SET title='$news[title]', img='$news[img]', details='$news[details]'
            WHERE news_id = '$news[id]'
            LIMIT 1";
    $result = mysqli_query($db,$sql);
    if($result){
        return true;
    }else{
        echo mysqli_error($db);
        db_disconnect($db);
        exit();
    }
}

function delete_news($id) {
    global $db;
    $id= db_escape($db,$id);

    $sql = "DELETE FROM news WHERE news_id='$id' LIMIT 1";
    $result = mysqli_query($db,$sql);
    if ($result){
        return true;
    }else{
        echo mysqli_error($db);
        db_disconnect($db);
        exit();
    }
}


function find_all_bloggers(){
    global $db;

    $sql = "SELECT * FROM blogger ORDER BY publish_date DESC, blogger_id DESC ";
    $result = mysqli_query($db,$sql);
    confirm_result_set($result);
    return $result;
}

function find_blogger_by_id($id,$options=[]){
    global $db;
    $id= db_escape($db,$id);

    $sql = "SELECT * FROM blogger WHERE blogger_id = '$id' ";
    $result = mysqli_query($db,$sql);
    confirm_result_set($result);
    $blogger = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $blogger;
}

function insert_blogger($blogger){
    global $db;

    $errors = validate_blog($blogger);
    if(!empty($errors)){
        return $errors;
    }

    $blogger['title']= db_escape($db,$blogger['title']);
    $blogger['content'] = db_escape($db,$blogger['content']);
    $blogger['img'] = db_escape($db,$blogger['img']);

    $sql = "INSERT INTO blogger (title,publish_date,img,content)
            VALUES('$blogger[title]','$blogger[publish_date]','$blogger[img]','$blogger[content]')";
    $result = mysqli_query($db,$sql);
    if($result){
        return true;
    }else{
        echo mysqli_error($db);
        db_disconnect($db);
        exit();
    }
}

function validate_blog($blogger,$options=[]) {

    $errors = [];

    // news_title
    if(is_blank($blogger['title'])) {
        $errors[] = "يجب ملأ خانة عنوان المقالة";
    }elseif(!has_length($blogger['title'], ['min' => 6, 'max' => 255])) {
        $errors[] = "العنوان يجد أن يكون بين 6 الى 255 حرف";
    }

    // news_content
    if(is_blank($blogger['content'])) {
        $errors[] = "يجب ملأ خانة محتوى المقالة";
    }



    return $errors;
}

function update_blogger($blogger){
    global $db;

    $errors = validate_blog($blogger);
    if(!empty($errors)){
        return $errors;
    }

    $blogger['id']= db_escape($db,$blogger['id']);
    $blogger['title']= db_escape($db,$blogger['title']);
    $blogger['content'] = db_escape($db,$blogger['content']);
    $blogger['img'] = db_escape($db,$blogger['img']);

    $sql = "UPDATE blogger 
            SET title='$blogger[title]', img='$blogger[img]', content='$blogger[content]'
            WHERE blogger_id = '$blogger[id]'
            LIMIT 1";
    $result = mysqli_query($db,$sql);
    if($result){
        return true;
    }else{
        echo mysqli_error($db);
        db_disconnect($db);
        exit();
    }
}

function delete_blogger($id) {
    global $db;
    $id= db_escape($db,$id);

    $sql = "DELETE FROM blogger WHERE blogger_id='$id' LIMIT 1";
    $result = mysqli_query($db,$sql);
    if ($result){
        return true;
    }else{
        echo mysqli_error($db);
        db_disconnect($db);
        exit();
    }
}


function find_all_categories(){
    global $db;

    $sql = "SELECT * FROM categories ORDER BY category ASC ";
    $result = mysqli_query($db,$sql);
    confirm_result_set($result);
    return $result;
}

function insert_category($categ){
    global $db;

    $errors = validate_category($categ);
    if(!empty($errors)){
        return $errors;
    }

    $categ['category']= db_escape($db,$categ['category']);

    $sql = "INSERT INTO categories (category)
            VALUES('$categ[category]')";
    $result = mysqli_query($db,$sql);
    if($result){
        return true;
    }else{
        echo mysqli_error($db);
        db_disconnect($db);
        exit();
    }
}

function validate_category($categ,$options=[]) {

    $errors = [];

    // league_name
    if(is_blank($categ['category'])) {
        $errors[] = "يجب ملأ خانة التصنيف";
    }elseif(!has_length($categ['category'], ['min' => 6, 'max' => 255])) {
        $errors[] = "الاسم يجد أن يكون بين 6 الى 255 حرف";
    }elseif (!has_unique_categ($categ['category'],$categ['category_id']??'0')){
        $errors[] = "هذا الاسم غير متاح. يرجى ادخال اسم آخر";
    }

    return $errors;
}

function update_category($categ){
    global $db;

    $errors = validate_category($categ);
    if(!empty($errors)){
        return $errors;
    }

    $categ['id']= db_escape($db,$categ['id']);
    $categ['category']= db_escape($db,$categ['category']);

    $sql = "UPDATE categories 
            SET category='$categ[category]'
            WHERE category_id = '$categ[id]'
            LIMIT 1";
    $result = mysqli_query($db,$sql);
    if($result){
        return true;
    }else{
        echo mysqli_error($db);
        db_disconnect($db);
        exit();
    }
}

function delete_category($id) {
    global $db;
    $id= db_escape($db,$id);

    $sql = "DELETE FROM categories WHERE category_id='$id' LIMIT 1";
    $result = mysqli_query($db,$sql);
    if ($result){
        return true;
    }else{
        echo mysqli_error($db);
        db_disconnect($db);
        exit();
    }
}


function find_all_videos($options=[]){
    global $db;

    $category_id = $options['category_id'] ?? false;
    $limit = $options['limit'] ?? false;
    $start = $options['start'] ?? false;
    $step = $options['step'] ?? false;

    $sql = "SELECT * FROM videos ";
    if ($category_id){
        $sql .= "WHERE category_id = '$category_id' ";
    }
    $sql.= "ORDER BY video_id DESC ";
    if ($limit){
        $sql .= "LIMIT {$limit}";
    }
    if ($start && $step){
        $sql .= "LIMIT {$start}, {$step}";
    }
    $result = mysqli_query($db,$sql);
    confirm_result_set($result);
    return $result;
}

function find_video_by_id($id,$options=[]){
    global $db;
    $id= db_escape($db,$id);

    $sql = "SELECT * FROM videos WHERE video_id = '$id' ";
    $result = mysqli_query($db,$sql);
    confirm_result_set($result);
    $video = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $video;
}

function insert_video($video){
    global $db;

    $errors = validate_video($video);
    if(!empty($errors)){
        return $errors;
    }

    $video['video_title']= db_escape($db,$video['video_title']);
    $video['category_id'] = db_escape($db,$video['category_id']);
    $video['video'] = db_escape($db,$video['video']);
    $video['video_date'] = db_escape($db,$video['video_date']);

    $sql = "INSERT INTO videos (category_id,video_title,video,video_date)
            VALUES('$video[category_id]','$video[video_title]','$video[video]','$video[video_date]')";
    $result = mysqli_query($db,$sql);
    if($result){
        return true;
    }else{
        echo mysqli_error($db);
        db_disconnect($db);
        exit();
    }
}

function validate_video($video,$options=[]) {

    $errors = [];

    // news_title
    if(is_blank($video['video_title'])) {
        $errors[] = "يجب ملأ خانة عنوان الفيديو";
    }elseif(!has_length($video['video_title'], ['min' => 6, 'max' => 255])) {
        $errors[] = "العنوان يجد أن يكون بين 6 الى 255 حرف";
    }elseif ( preg_match('/\s/',$video['video']) ){
        $errors[] = "اسم الفيديو يجب أن لا يحتوي على مسافات";
    }

    return $errors;
}

function update_video($video){
    global $db;

    $errors = validate_video($video);
    if(!empty($errors)){
        return $errors;
    }

    $video['id']= db_escape($db,$video['id']);
    $video['video_title']= db_escape($db,$video['video_title']);
    $video['category_id'] = db_escape($db,$video['category_id']);
    $video['video'] = db_escape($db,$video['video']);

    $sql = "UPDATE videos 
            SET video_title='$video[video_title]', category_id='$video[category_id]', video='$video[video]'
            WHERE video_id = '$video[id]'
            LIMIT 1";
    $result = mysqli_query($db,$sql);
    if($result){
        return true;
    }else{
        echo mysqli_error($db);
        db_disconnect($db);
        exit();
    }
}

function delete_video($id) {
    global $db;
    $id= db_escape($db,$id);

    $sql = "DELETE FROM videos WHERE video_id='$id' LIMIT 1";
    $result = mysqli_query($db,$sql);
    if ($result){
        return true;
    }else{
        echo mysqli_error($db);
        db_disconnect($db);
        exit();
    }
}


function find_all_matches($options=[]){
    global $db;

    $league_id = $options['league_id'] ?? false;
    $time = $options['time'] ?? false;
    $limit = $options['limit'] ?? false;

    $sql = "SELECT * FROM matches ";
    if ($league_id){
        $sql .= "WHERE league_id = '$league_id' ";
    }
    if ($time){
        $sql .= "AND match_date = '$time' ";
    }
    $sql.= "ORDER BY match_date DESC, match_time DESC ";
    if ($limit){
        $sql .= "LIMIT {$limit}";
    }
    $result = mysqli_query($db,$sql);
    confirm_result_set($result);
    return $result;
}

function insert_match($match){
    global $db;

    $errors = validate_match($match);
    if(!empty($errors)){
        return $errors;
    }

    $match['league_id']= db_escape($db,$match['league_id']);
    $match['team1'] = db_escape($db,$match['team1']);
    $match['team2'] = db_escape($db,$match['team2']);
    $match['match_date'] = db_escape($db,$match['match_date']);
    $match['match_time'] = db_escape($db,$match['match_time']);
    $match['match_url'] = db_escape($db,$match['match_url']);

    $sql = "INSERT INTO matches (league_id,team1,team2,match_date,match_time,match_url)
            VALUES('$match[league_id]','$match[team1]','$match[team2]','$match[match_date]','$match[match_time]','$match[match_url]')";
    $result = mysqli_query($db,$sql);
    if($result){
        return true;
    }else{
        echo mysqli_error($db);
        db_disconnect($db);
        exit();
    }
}

function validate_match($match,$options=[]) {

    $errors = [];

    // news_title
    if(($match['team1'] == $match['team2'])) {
        $errors[] = "يجب اختيار فريقين مختلفين";
    }

    return $errors;
}

function update_match($match){
    global $db;

    $errors = validate_match($match);
    if(!empty($errors)){
        return $errors;
    }

    $match['id']= db_escape($db,$match['id']);
    $match['league_id']= db_escape($db,$match['league_id']);
    $match['team1'] = db_escape($db,$match['team1']);
    $match['team2'] = db_escape($db,$match['team2']);
    $match['match_date'] = db_escape($db,$match['match_date']);
    $match['match_time'] = db_escape($db,$match['match_time']);
    $match['match_url'] = db_escape($db,$match['match_url']);

    $sql = "UPDATE matches 
            SET league_id='$match[league_id]', team1='$match[team1]', team2='$match[team2]',match_date='$match[match_date]',match_time='$match[match_time]',match_url='$match[match_url]'
            WHERE match_id = '$match[id]'
            LIMIT 1";
    $result = mysqli_query($db,$sql);
    if($result){
        return true;
    }else{
        echo mysqli_error($db);
        db_disconnect($db);
        exit();
    }
}

function delete_match($id) {
    global $db;
    $id= db_escape($db,$id);

    $score_set = find_all_score(['match_id' => $id]);
    $row_count = mysqli_num_rows($score_set);

    if ($row_count == 1){
        $remove = "DELETE FROM scores WHERE match_id='$id' LIMIT 1";
        $result1 = mysqli_query($db,$remove);

        if ($result1){
            $sql = "DELETE FROM matches WHERE match_id='$id' LIMIT 1";
            $result = mysqli_query($db,$sql);

            if ($result){
                return true;
            }else{
                echo mysqli_error($db);
                db_disconnect($db);
                exit();
            }
        }else{
            echo mysqli_error($db);
            db_disconnect($db);
            exit();
        }
    }else{
        $sql = "DELETE FROM matches WHERE match_id='$id' LIMIT 1";
        $result = mysqli_query($db,$sql);

        if ($result){
            return true;
        }else{
            echo mysqli_error($db);
            db_disconnect($db);
            exit();
        }
    }
}


function find_all_score($options=[]){
    global $db;

    $match_id = $options['match_id'] ?? false;

    $sql = "SELECT * FROM scores ";
    if ($match_id){
        $sql .= "WHERE match_id = '$match_id' ";
    }
    $result = mysqli_query($db,$sql);
    confirm_result_set($result);
    return $result;
}

function insert_score($score){
    global $db;

    /*$errors = validate_match($match);
    if(!empty($errors)){
        return $errors;
    }*/

    $sql = "INSERT INTO scores (match_id,team1,team2)
            VALUES('$score[match_id]','$score[team1]','$score[team2]')";
    $result = mysqli_query($db,$sql);
    if($result){
        return true;
    }else{
        echo mysqli_error($db);
        db_disconnect($db);
        exit();
    }
}