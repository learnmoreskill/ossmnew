<?php
include("session.php");
require_once("../config/pagination.class.php");
$perPage = new PerPage();


	
$sql = "SELECT * FROM `studentinfo` LEFT JOIN `parents` ON `studentinfo`.`sparent_id`=`parents`.`parent_id` WHERE `studentinfo`.`status`<> 0  ORDER BY `studentinfo`.`sclass`, `studentinfo`.`ssec`, `studentinfo`.`sroll`";

$paginationlink = "getstudentlist.php?page=";
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
                                <th>Admit no</th>
                                <th>Roll no</th>
                                <th>Name</th>
                                <th>Gender</th>
                                <th>Class</th>
                                <th>Address</th>
                                <th>Parent</th>
                                <th>Status</th>
                                <th style="width: 120px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>';
foreach($faq as $k=>$v) {

 $output .= '
 <div class="question"><input type="hidden" id="rowcount" name="rowcount" value="' . $_GET["rowcount"] . '" />
     <tr ' . (($faq[$k]["status"]==1) ? 'style="background-color: #ea80fc "' : '').(($faq[$k]["status"]==2) ? 'style="background-color: #ccff90"' : '') . ' >
        <td>
        '. $faq[$k]["sadmsnno"] .'
          
        </td>
        <td>
        '. $faq[$k]["sroll"] .'
          
        </td>
        <td>
            '. $faq[$k]["sname"] .'
        </td>
        <td>
            '. $faq[$k]["sex"] .'
        </td>
        <td>
            '. $faq[$k]["sclass"] .' '. $faq[$k]["ssec"] .'
        </td>
        <td>
            '. $faq[$k]["saddress"] .'
        </td>
        <td>
            ' . (empty($faq[$k]["spname"]) ? $faq[$k]["smname"] : $faq[$k]["spname"]) . '
        </td>
        <td>
            ' . (($faq[$k]["status"]==1) ? 'Left' : '').(($faq[$k]["status"]==2) ? 'Passed out' : '') . '
        </td>
        <td style="min-width: 120px;">

            <a href="studentdetailsdescription.php?token=2ec9ys77bi89s9&key=ae25nj5s3fr596dg@'.$faq[$k]["sid"].'">
                <div class="tooltipped" data-position="right" data-delay="50" data-tooltip="information" style="font-weight: 400;vertical-align:middle; display: inline-flex; padding-bottom: 3px;">
                    <i class="material-icons">
                        info_outline
                    </i>
                </div>
            </a>

            <a href="viewmarksheet.php?token=2ec9ys77bi89s9&key=ae25nj5s3fr596dg@'.$faq[$k]["sid"].'">
                <div class="tooltipped" data-position="right" data-delay="50" data-tooltip="markshet of student" style="font-weight: 400;vertical-align:middle; display: inline-flex; padding-bottom: 3px;">
                    <i class="material-icons orange-text text-lighten-1">
                        timeline
                    </i>
                </div>
            </a>

            <a href="admitstudent.php?token=2ec9ys77bi8939&key=ae25nj53sfr596dg@'.$faq[$k]["sid"].'">
                <div class="tooltipped" data-position="left" data-delay="50" data-tooltip="edit" style="font-weight: 400;vertical-align:middle; display: inline-flex; padding-bottom: 3px;">
                    <i class="material-icons green-text text-lighten-1">
                        edit
                    </i>
                </div>
            </a>

            <a href="deleteuserscript.php?token=6yugyf67gh4esw&key=ae25nJ5s3fr596dg@'.$faq[$k]["sid"].'" onclick = " return confirm(\'Are you sure want to re-active?\')" >
                <div class="tooltipped" data-position="left" data-delay="50" data-tooltip="re-active" style="font-weight: 400;vertical-align:middle; display: inline-flex; padding-bottom: 3px;">
                    <i class="material-icons teal-text text-darken-4">
                        autorenew
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
