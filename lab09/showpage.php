<?php
require_once 'cfg.php';

function PokazPodstrone($id) {
    global $link;

    $id_clear = htmlspecialchars($id);

    $query = "SELECT * FROM page_list WHERE id = '$id_clear' LIMIT 1";
    $result = mysqli_query($link, $query);

    $row = mysqli_fetch_array($result);

    if (empty($row['id'])) {
        $web = '[Page not found]';
    } else {
        $web = $row['page_content'];
    }

    return $web;
}

if (isset(htmlspecialchars($_GET['id'])) {
    echo PokazPodstrone(htmlspecialchars($_GET['id']);
} else {
    echo '[No page ID provided]';
}
?>
