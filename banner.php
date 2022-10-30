<?php
function x()
{
    $link = mysqli_connect("localhost", "root", "", "banner");
    if ($link === false) {
        die("ERROR: Could not connect. " . mysqli_connect_error());
    }
    $ip_address = $_SERVER['REMOTE_ADDR'];
    $userAgent = $_SERVER['HTTP_USER_AGENT'];
    $date = date('Y-m-d h:i:s');
    $page_url = $_SERVER['HTTP_REFERER'];
    $sql = "SELECT * FROM banners WHERE ip_address='$ip_address' AND user_agent='$userAgent' AND page_url='$page_url' ";
    if ($result = mysqli_query($link, $sql)) {
        if (mysqli_num_rows($result) > 0) {
            var_dump($result);
            $row = mysqli_fetch_array($result);
            $id = $row['id'];
            $viewCount = $row['view_count'] + 1;
            $updateSql = "UPDATE banners SET `view_count`='$viewCount',`view_date`='$date' WHERE id='$id'";
            if (mysqli_query($link, $updateSql)) {
                echo "ERROR: Could not able to execute $updateSql. " . mysqli_error($link);
            }
        } else {
            $insertSql = "INSERT INTO banners (ip_address, user_agent, view_date,page_url,view_count)
        VALUES ('$ip_address','$userAgent','$date','$page_url','1')";
            if (!mysqli_query($link, $insertSql)) {
                echo $link->error;
            }
        }
    }
}

header("Content-Type: image/png");

x();
?>