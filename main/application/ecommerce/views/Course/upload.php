<?php
function heal_string($string)
{

    $string = trim($string);

    $string = str_replace(
        array('�', '�', '�', '�', '�', '�', '�', '�', '�'),
        array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'),
        $string
    );

    $string = str_replace(
        array('�', '�', '�', '�', '�', '�', '�', '�'),
        array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),
        $string
    );

    $string = str_replace(
        array('�', '�', '�', '�', '�', '�', '�', '�'),
        array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),
        $string
    );

    $string = str_replace(
        array('�', '�', '�', '�', '�', '�', '�', '�'),
        array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),
        $string
    );

    $string = str_replace(
        array('�', '�', '�', '�', '�', '�', '�', '�'),
        array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
        $string
    );

    $string = str_replace(
        array('�', '�', '�', '�'),
        array('n', 'N', 'c', 'C',),
        $string
    );

    $string = str_replace(
        array("\\", "?", "�", "-", "~",
             "#", "@", "|", "!", "\"",
             "�", "$", "%", "&", "/",
             "(", ")", "?", "'", "�",
             "�", "[", "^", "`", "]",
             "+", "}", "{", "?", "?",
             ">", "< ", ";", ",", ":", " "),
        '',
        $string
    );


    return $string;
}
// defino la carpeta para subir
$uploaddir = '../../assets/images/';
// defino el nombre del archivo
$uploadfile = $uploaddir . 'course_'.  basename(heal_string($_FILES['userfile']['name']));
// Lo mueve a la carpeta elegida
umask(0);
if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
  echo "success";
} else {
  echo "error";
}
?>
