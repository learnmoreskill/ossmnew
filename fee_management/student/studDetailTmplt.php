<?php
  $student_details = json_decode($account->get_student_details_by_sid($student_id));

  $spname = $student_details->spname;
  $sadmsnno = $student_details->sadmsnno;
  $class_id=$student_details->sclass;
  $section_id = $student_details->ssec;
  $class_name = $student_details->class_name;
  $section_name = $student_details->section_name; 
  $dob = $student_details->dob;
  $sroll = $student_details->sroll;
  $sname = $student_details->sname;
  $saddress = $student_details->saddress;
  $spnumber = $student_details->spnumber;
  $payment_type=$student_details->payment_type;
  $status=$student_details->status;
?><div class="col-md-2 col-sm-3">

    <div class="card">
      <div class="card-body text-center">
        <img class="card-img-top stuImg" src="<?php  if($student_details->simage!=''){ echo "../../uploads/".$fianlsubdomain."/profile_pic/".$student_details->simage; } else { echo "https://learnmoreskill.github.io/important/dummystdmale.png";} ?>" alt="Card image cap" >
        <h4 class="card-title no-margin" ><a class=""><?php echo $sname; ?></a></h4>
        <p class="card-text">Address : <?php echo $saddress; ?></p>
      </div>
    </div>
</div>

<div class="col-md-10 col-sm-9 overflowScroll">
  	<table class="table table-hover table-bio" style="padding-top:6%;">
      <tbody>
        <tr>
          <th scope="row">Father Name :</th>
          <td><?php echo $spname; ?></td>
          <th scope="row">Admission No:</th>
          <td><?php echo $sadmsnno; ?></td>
        </tr>
        <tr>
      <th scope="row">Phone No :</th>
          <td><?php echo $spnumber; ?></td>
          <th scope="row">Class:</th>
          <td><?php echo $class_name; ?> &nbsp <?php echo $section_name; ?></td>
        </tr>
        <tr>
        <th scope="row">Date of Birth :</th>
          <td><?php echo $dob; ?></td>
          <th scope="row">Roll No :</th>
          <td><?php echo $sroll; ?></td>
        </tr>
        <tr>
        <th scope="row">Payment Mode</th>
          <td><?php if($payment_type==0)echo "Monthly"; else echo "Yearly";
           ?></td>
           <th scope="row">Status</th>
           <?php if($status==0) echo "<td style='color:green;'><b><u>ACTIVE<u><b></td>"; elseif($status==1) echo "<td style='color:red;'><b>INACTIVE<b></td>"; elseif($status==2) echo "<td style='color:gold;'><b>PASSED OUT<b></td>"; ?>
        </tr>    
      </tbody>
  </table>
</div>