<?php

function PokazPodstrone($id, $link)
{
    $id_clear = htmlspecialchars($id);

    $query = "SELECT * FROM page_list WHERE alias = ? LIMIT 1";
    $stmt = mysqli_prepare($link, $query);

    if (!$stmt) {
        die("Error preparing statement: " . mysqli_error($link));
    }

    mysqli_stmt_bind_param($stmt, 's', $id_clear);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_array($result);

    if (empty($row['id'])) {
        return '[nie_znaleziono_strony]';
    }

    return $row['page_content'];
}

?>