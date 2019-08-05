<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="../css/marksheet7.css"   type="text/css" media="print,screen" >
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet" type="text/css" >
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <meta charset="UTF-8">
    <title>Results</title>
    <style>
        @media print {
            @page {
                size: A4 landscape;
            }
        }
    </style>
</head>

<body>

    <!-- <button onclick="window.print()">Print</button> -->

    <div class=" margincss pageBreak border">
        <div class="schoolHeader">
            <div class="text-uppercase text-center w-75 m-auto">
                <p class="font-weight-bold small m-0 p-0">"Education For Peace And Prosperity"</p>
                <h5 class="font-weight-bold m-0 p-0 schoolname"> Shree Trijuddha Mahabir Prasad Raghubir Ram Ucha Madhyamik Bidhyalaya</h5>
                <h6 class="font-weight-bold m-0 p-0">Birta Birgunj, Nepal</h6>
                <p class="small m-0 p-0">PH NO: 021-657575</p>
                <h6 class="font-weight-bold m-0 p-0">Annual Academic Report - 2076</h6>

            </div>
            <!-- school logo -->
            <div class="logoContainer" style="top: 0px;">
                <img src="img/logo.png" class="logo" alt="">
            </div>
            <!-- school phone -->
           <!--  <div class="logoContainer" style="right: 10px;top: 49% ">
                <p class="small">PH NO: 021-657575</p>

            </div> -->
        </div>

        <hr class="m-0">

        <div class="row">
            <div class="col-sm-4" class="divBorder">

                <p class="m-0 ml-1"><b>NAME:</b> SMIRITI KHANAL</p>
            </div>
            <div class="col-sm-8">

                <p class="text-uppercase m-0">
                    <span><b>CLASS:</b><span class="mx-2">nine</span> </span>
                    <span><b>section:</b><span  class="mx-2">mr eintein aruna shrestha</span> </span>
                    <span><b>rollno:</b><span  class="mx-2">1</span> </span>

                </p>
            </div>
        </div>
        <table class=" text-center table table-bordered  vAlignM m-0">
            <thead>
                <tr>
                    <th rowspan="3" align="center">S.N.</th>
                    <th rowspan="3">SUBJECT</th>
                    <th rowspan="3">Full Marks</th>
                    <th rowspan="3">Pass Marks</th>
                    <th colspan="8">MARKS OBTAINED</th>

                    <th rowspan="3">Unit Test 15%</th>
                    <th rowspan="3">First Term 15%</th>
                    <th rowspan="3">Second Term 15%</th>
                    <th rowspan="3">Annual 55%</th>
                    <th rowspan="3">Total</th>
                    <th rowspan="3"><span class="textVertical">Grade</span></th>
                    <th rowspan="3"><span class="textVertical">Point</span></th>
                    <th rowspan="3">Highest Mark</th>

                </tr>
                <tr>
                    <td colspan="2">1st</td>
                    <td colspan="2">2nd</td>
                    <td>3rd</td>
                    <td colspan="3">Annual</td>
                </tr>
                <tr>
                    <td>Unit</td>
                    <td>Term</td>
                    <td>Unit</td>
                    <td>Term</td>
                    <td>Unit</td>
                    <td>Th</td>
                    <td>Pr</td>
                    <td>Total</td>
                </tr>

            </thead>
            <tbody>
                <?php 
              for($i=1;$i<=8;$i++)
              {
                  echo "<tr>";
                  echo "<td >$i</td>";
                  echo "<td >subject $i</td>";

                  for($J=1;$J<=18;$J++)
                  {

                      echo "<td >$J</td>";
                  }
                  echo "</tr>";
              }
              ?>
                    <!-- tottal -->
                    <tr>
                        <td colspan="2" class="font-weight-bold">subject 8</td>
                        <td>1</td>
                        <td>2</td>
                        <td>3</td>
                        <td>4</td>
                        <td>5</td>
                        <td>6</td>
                        <td>7</td>
                        <td>8</td>
                        <td>9</td>
                        <td>10</td>
                        <td>11</td>
                        <td>12</td>
                        <td>13</td>
                        <td>14</td>
                        <td>15</td>
                        <td>16</td>
                        <td>17</td>
                        <td>18</td>
                    </tr>

            </tbody>
        </table>

        <!-- <hr> -->
        <div class="row m-0">
            <div class="col-sm-2 p-0">
                <p class="m-0">
                    <span><b>Result:</b><span >Passed</span> </span>
                </p>
            </div>
            <div class="col-sm-2 p-0">
                <p class="m-0"> <span><b>Division: </b><span >Distinction</span> </span>
                </p>
            </div>
            <div class="col-sm-2 p-0">
                <p class="m-0"><span><b>Attendance: </b><span > 228/230</span> </span>
                </p>
            </div>
            <div class="col-sm-2 p-0">
                <p class="m-0"><span><b>Percentage: </b><span> 80% </span> </span>
                </p>
            </div>
            <div class="col-sm-2 p-0">
                <p class="m-0"><span><b>Rank: </b><span > 5/164</span> </span>
                </p>
            </div>
            <div class="col-sm-2 p-0">
                <p class="m-0"><span><b>GPA: </b><span > 3.2</span> </span>
                </p>
            </div>
        </div>
        <hr class="m-0">

        <table class="text-center table table-bordered  vAlignM text-uppercase profilereport m-0">
            <thead>
                <tr>
                    <th>Profile Report</th>
                    <th>Grade</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Homework</td>
                    <td>A+</td>
                </tr>
                <tr>
                    <td>Cleanliness</td>
                    <td>A+</td>
                </tr>
                <tr>
                    <td>Discipline</td>
                    <td>A+</td>
                </tr>
                <tr>
                    <td>Handwriting</td>
                    <td>A+</td>
                </tr>
                <tr>
                    <td>Moral Discipline</td>
                    <td>A+</td>
                </tr>
            </tbody>
        </table>

        <h5 class="text-capitalize m-0"><span class="small text-uppercase mr-1">Remarks: </span><b>Outstanding Performance. Upgraded to class _________________</b></h5>

        <div class="row signaturecontainer">
            <div class="col-sm-4 text-center" style="position: relative;">
                <span class="text-center">              
              _____________ <br>           
              DATE
            </span>
                <span style="position: absolute;top: 0%;right: 40%">2076/02/17</span>

            </div>
            <div class="col-sm-4 text-center" style="position: relative;">
                <span class="text-center">              
                _____________ <br>           
                CLASS TEACHER
              </span>
                <img src="img/sign.png" style="width:150px; height: 100px;position: absolute;top: -95%;right: 31%">

            </div>
           <!--  <div class="col-sm-3 text-center" style="position: relative;">
                <span class="text-center">              
                _____________ <br>           
                SCHOOL'S SEAL
              </span>
                <img src="img/seal.png" style="width:100px; height: 100px;position: absolute;top: -137%;right: 34%">

            </div> -->
            <div class="col-sm-4 text-center" style="position: relative;">
                <span class="text-center">              
                _____________ <br>           
                PRINCIPAL
              </span>
                <img src="img/sign.png" style="width:150px; height: 100px;position: absolute;top: -95%;right: 31%">

            </div>

        </div>
        <hr class="m-0">

        <div class="row m-0">
            <div class="col-sm-6 p-0">
                <h5 class="text-center m-0"><u>Explanation of grade</u></h5>

                <table class="text-center table table-bordered  vAlignM text-uppercase m-0">

                    <thead>
                        <tr>
                            <th>90%-100%</th>
                            <th>80%-90%</th>
                            <th>70%-80%</th>
                            <th>60%-70%</th>
                            <th>50%-60%</th>
                            <th>40%-50%</th>
                            <th>30%-40%</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>A</td>
                            <td>A</td>
                            <td>A</td>
                            <td>A</td>
                            <td>A</td>
                            <td>A</td>
                            <td>A</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-sm-3"></div>
            <div class=" col-sm-3 p-0">
                <h5 class="text-center m-0"><u>Key</u></h5>

                <table class="text-center table table-bordered vAlignM text-uppercase  m-0">
                    <thead>

                        <th>*</th>
                        <th>F</th>
                        <th>Ab</th>
                    </thead>
                    <tbody>
                        <tr>

                            <td>Distinction</td>
                            <td>Fail</td>
                            <td>Absent</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
   
    <!-- this pagebreak is required if page break in print -->
    <div class="pageBreak"></div>
</body>

</html>