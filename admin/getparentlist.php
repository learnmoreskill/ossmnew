<?php
include("session.php");
require_once("../config/pagination.class.php");
$perPage = new PerPage();


	
$sql = "SELECT * FROM parents WHERE `spstatus` = 0";
$paginationlink = "getparentlist.php?page=";	
$pagination_setting = $_GET["pagination_setting"];
				
$page = 1;
if(!empty($_GET["page"])) {
$page = $_GET["page"];
}

$start = ($page-1)*$perPage->perpage;
if($start < 0) $start = 0;

$query =  $sql . " limit " . $start . "," . $perPage->perpage;

$result = $db->query($query);
	while($row=$result->fetch_assoc()) {
		$resultset[] = $row;
	}		
	if(!empty($resultset))
$faq = $resultset;

if(empty($_GET["rowcount"])) {

	$result  = $db->query($sql);
	$rowcount = mysqli_num_rows($result);

	$_GET["rowcount"] = $rowcount;
}

if($pagination_setting == "prev-next") {
	$perpageresult = $perPage->getPrevNext($_GET["rowcount"], $paginationlink,$pagination_setting);	
} else {
	$perpageresult = $perPage->getAllPageLinks($_GET["rowcount"], $paginationlink,$pagination_setting);	
}


$output = '<div class="row">
				<div class="col s12 m12">
                    <table class="centered bordered striped highlight z-depth-4">
                        <thead>
                            <tr>
                                <th>Father name</th>
                                <th>Mother name</th>
                                <th>Mobile</th>
                                <th>Profession</th>
                                <th>Address</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>';
foreach($faq as $k=>$v) {

 $output .= '
 <div class="question"><input type="hidden" id="rowcount" name="rowcount" value="' . $_GET["rowcount"] . '" />
     <tr>
        <td>
        '. $faq[$k]["spname"] .'
          
        </td>
        <td>
        '. $faq[$k]["smname"] .'
          
        </td>
        <td>
            '. $faq[$k]["spnumber"] .'
        </td>
        <td>
            '. $faq[$k]["spprofession"] .'
        </td>
        <td>
            '. $faq[$k]["spaddress"] .'
        </td>
        <td>
            <a href="parent.php?token=2ec9ys77bi89s9&key=ae25nj5s3fr596dg@'.$faq[$k]["parent_id"].'">
                <div class="tooltipped" data-position="left" data-delay="50" data-tooltip="information" style="font-weight: 400;vertical-align:middle; display: inline-flex; padding-bottom: 3px;">
                    <i class="material-icons">
                        info_outline
                    </i>
                </div>
            </a>

            <a  href="admitstudent.php?token=2ecpoij7bi8939&key=ae25nj53sfr596dg@'.$faq[$k]["parent_id"].'"> 
                <div class="tooltipped" data-position="left" data-delay="50" data-tooltip="edit" style="font-weight: 400;vertical-align:middle; display: inline-flex; padding-bottom: 3px;">
                    <i class="material-icons green-text text-lighten-1">
                        edit
                    </i>
                </div>
            </a>

            <a href="deleteuserscript.php?token=fd5576t7ygr56&key=ae25nJ5s3fr596dg@'.$faq[$k]["parent_id"].'" onclick = " return confirm(\'Are you sure want to delete?\')" >
                <div class="tooltipped" data-position="left" data-delay="50" data-tooltip="delete" style="font-weight: 400;vertical-align:middle; display: inline-flex; padding-bottom: 3px;"> 
                    <i class="material-icons red-text text-darken-4">
                        delete
                    </i>
                </div>
            </a>


        </td>
    </tr>
</div>';

}
$output .= '</tbody>
                    </table>
                </div>
                </div>';

if(!empty($perpageresult)) {
$output .= '<div id="pagination">' . $perpageresult . '</div>';
}
print $output;
?>
