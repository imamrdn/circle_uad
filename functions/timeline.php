<?php 

function get_all_message()
{
    global $link;
    $query = "SELECT timeline.*, users.* FROM timeline INNER JOIN users ON timeline.id_user = users.id order by created_at DESC";

    $result = mysqli_query($link, $query);
    
    return $result;
}

function create_post($message, $created_at, $id_user)
{
    global $link;

    //avoid sql injection
    $message  = escape($message);

    $query = "INSERT INTO timeline (message, created_at, id_user) VALUES ('$message', '$created_at', '$id_user')";

    if (mysqli_query($link, $query)) return true;
    else return false;
}


?>