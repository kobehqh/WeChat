<?php
if($_SESSION['test']){
    echo $_SESSION['test'];
    echo "<hr/>";
    echo "11";
}else {
    $_SESSION['test'] = "hello";
    echo $_SESSION['test'];
    echo "2";
}
?>