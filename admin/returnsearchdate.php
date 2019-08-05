<?php
   include('session.php');

if (isset($_GET["redirectto"])) {
    $page = addslashes($_GET["redirectto"]);
    
    if($_SERVER["REQUEST_METHOD"] == "POST") { 
        
        $ugdate = mysqli_real_escape_string($db,$_POST["ugdate"]);
        
        ?><script> window.location.href = '<?php echo $page;?>.php?requestdate=<?php echo $ugdate;?>'; </script><?php 
    }
}

if (isset($_GET["byclass"])) {
    
    if($_SERVER["REQUEST_METHOD"] == "POST") { 
        
        $searchclass = mysqli_real_escape_string($db,$_POST['classsearch']);
        $searchsection = mysqli_real_escape_string($db,$_POST['sectionsearch']);
        
        ?><script> window.location.href = 'attendancebyclass.php?atbyclassview&setclass=<?php echo $searchclass;?>&setsec=<?php echo $searchsection;?>'; </script><?php 
    }
}


?>