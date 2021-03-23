<?php
/**
 * Created by PhpStorm.
 * User: eng-nanna
 * Date: 3/18/2018
 * Time: 8:10 PM
 */
require_once('../includes/initialize.php');
require_login();

$result = $_POST['selected'];
if ($result == "all"){
    $video_set = find_all_videos($options=[]);
}else{
    $video_set = find_all_videos(['category_id'=> $result]);
}
?>

<table width="100%" id="DisplayDiv">
    <thead>
    <th>عنوان الفيديو</th>
    <th class="text-center">تعديل</th>
    <th class="text-center">حذف</th>
    </thead>
    <tbody>
    <?php while($video = mysqli_fetch_assoc($video_set)) { ?>
        <tr>
            <td><?php echo htmlspecialchars($video['video_title']); ?></td>
            <td class="text-center editRow"><a href="edit_video.php?id=<?php echo htmlspecialchars(urlencode($video['video_id'])); ?> "><i class="fas fa-edit"></i></a></td>
            <td class="text-center removeRow"><a href="delete_video.php?id=<?php echo htmlspecialchars(urlencode($video['video_id'])); ?> "><i class="fas fa-trash-alt"></i></a></td>
        </tr>
    <?php }
    mysqli_free_result($video_set);?>
    </tbody>
</table>
