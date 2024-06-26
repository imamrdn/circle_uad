<?php

function get_all_user()
{
    global $link;
    $query = "SELECT * FROM users WHERE role = 'client'";
    $result = mysqli_query($link, $query);

    return $result;
}

function get_name_user()
{
    global $link;
    $query = "SELECT * FROM users";
    $result = mysqli_query($link, $query);

    return $result;
}

function get_user_by_id($id)
{
    global $link;
    $query = "SELECT * FROM users where id_user = $id";

    $result = mysqli_query($link, $query);

    return $result;
}

function get_user_by_email($email)
{
    global $link;
    $query = "SELECT * FROM users where email = '$email' LIMIT 1";

    $result = mysqli_query($link, $query);
    $result = mysqli_fetch_assoc($result);

    return $result;
}

function register_user($firstname, $lastname, $email, $password)
{
    global $link;

    //avoid sql injection
    $firstname  = escape($firstname);
    $lastname   = escape($lastname);
    $email      = escape($email);
    $password   = escape($password);

    //password hash
    $password = password_hash($password, PASSWORD_DEFAULT);

    $query = "INSERT INTO users (firstname, lastname, email, password) VALUES ('$firstname', '$lastname', '$email', '$password')";

    if (mysqli_query($link, $query)) return true;
    else return false;
}

function create_user($firstname, $lastname, $email, $password, $role)
{
    global $link;

    //avoid sql injection
    $firstname  = escape($firstname);
    $lastname   = escape($lastname);
    $email      = escape($email);
    $password   = escape($password);

    //password hash
    $password = password_hash($password, PASSWORD_DEFAULT);

    $query = "INSERT INTO users (firstname, lastname, email, password, role) VALUES ('$firstname', '$lastname', '$email', '$password','$role')";
    if (mysqli_query($link, $query)) return true;
    else return false;
}

function update_user($firstname, $lastname, $email, $password, $id)
{
    global $link;

    //avoid sql injection
    $firstname  = escape($firstname);
    $lastname   = escape($lastname);
    $email      = escape($email);
    $password   = escape($password);

    //password hash
    $password = password_hash($password, PASSWORD_DEFAULT);

    $query = "UPDATE users SET firstname = '$firstname', lastname = '$lastname', email = '$email', password = '$password' WHERE id_user = '$id'";
    
    if (mysqli_query($link, $query)) return true;
    else return false;
}

function check_email($email)
{
    global $link;
    $email  = escape($email);
    $query  = "SELECT * FROM users WHERE email = '$email'";

    if ($result = mysqli_query($link, $query))
        return mysqli_num_rows($result);
}

function check_data($email, $password)
{
    global $link;

    //avoid sql injection
    $email      = escape($email);
    $password   = escape($password);

    $query  = "SELECT password FROM users WHERE email = '$email'";
    $result = mysqli_query($link, $query);
    $hash = mysqli_fetch_assoc($result)['password'];

    if (password_verify($password, $hash)) return true;
    else return false;
}

// injection func
function escape($data)
{
    global $link;
    return mysqli_real_escape_string($link, $data);
}

function redirect($email)
{
    $_SESSION['user'] = $email;
    header('Location: index.php');
}

function set_flash_message($tipe, $pesan)
{
    $_SESSION['notifikasi'] = [
        'tipe' => $tipe,
        'pesan' => $pesan
    ];

    return true;
}

function show_flash_message()
{
    if (isset($_SESSION['notifikasi'])) {
        $tipe = $_SESSION['notifikasi']['tipe'];
        $pesan = $_SESSION['notifikasi']['pesan'];
        echo "<script> Toast.fire({ icon: '$tipe', title: '$pesan'  }); </script>";
        unset($_SESSION['notifikasi']);
    }
}

function check_role($name)
{
    global $link;
    $name = escape($name);

    $query  = "SELECT role FROM users WHERE email = '$name'";
    $result = mysqli_query($link, $query);
    $role = mysqli_fetch_assoc($result)['role'];

    return $role;
}

function delete_user($id)
{
    global $link;
    $query = "DELETE FROM users WHERE id_user = $id";

    if (mysqli_query($link, $query)) return true;
    else return false; 
}

?>