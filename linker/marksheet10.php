<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="../css/marksheet7.css" type="text/css" media="print,screen">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <meta charset="UTF-8">
    <title>Results</title>
    <style>
        @media print {
                    @page {
                        size: A4 portrait;
                    }
                }

        .hidebackground{
            background: none!important;

        }
        .hide{
            visibility: hidden;
        }
       
        
       .removeborder>thead>tr>th, .removeborder>tbody>tr>td, .removeborder{
             border: 2px white solid !important;
            }
    </style>
    <script type="text/javascript">
      function toggleclasses(){
        if(document.getElementById('fullFormat').checked){
            $(".hide").addClass('hide1');

            $(".hide").removeClass('hide');

            $(".hidebackground").addClass('hidebackground1');

            $(".hidebackground").removeClass('hidebackground');

            $(".removeborder").addClass('removeborder1');

            $(".removeborder").removeClass('removeborder');
        }
        else{
            $(".hide1").addClass('hide');

            $(".hide1").removeClass('hide1');

            $(".hidebackground1").addClass('hidebackground');

            $(".hidebackground1").removeClass('hidebackground1');

            $(".removeborder1").addClass('removeborder');

            $(".removeborder1").removeClass('removeborder1');
        }
        
        // var hideback=document.getElementsByClassName("hidebackground");
        // var hide=document.getElementsByClassName("hide");
        // var removeborder=document.getElementsByClassName("removeborder");
        // for (var i = 0; i < hide.length; i++) {
        //     hide[i].classList.add('hide1');

        //     hide[i].classList.remove('hide');
        // }
        // for (var i = 0; i < hideback.length; i++) {
        //     hideback[i].classList.add('hidebackground1');

        //     hideback[i].classList.remove('hidebackground');
        // }
        // for (var i = 0; i < removeborder.length; i++) {

        //     removeborder[i].classList.add('removeborder1');
        //     var t=removeborder[i].classList.remove('removeborder');
        //     debugger;


        // }
        debugger;

      }
    </script>
</head>

<body >
    <input type="checkbox" id="fullFormat" onchange="toggleclasses()" name="completeformat">Show Full Format<br>
    <!-- <button onclick="window.print()">Print</button> -->
    <div class=" margincss pageBreak border bg-success hidebackground divpadding removeborder" style="position: relative;">
        <div class="bg-white">
            <div class="schoolHeader p-2 hide" style="height:90px;">
                <div class="text-uppercase text-center w-75 m-auto">
                    <h1 class="font-weight-bold m-0 p-0 schoolkadam">KADAMBARI ACADEMY</h1>
                    <p class="small m-0 p-0">SHREEPUR, BIRGUNJ (NEPAL) PH NO: 021-657575</p>
                </div>
                <div class="logoContainer" style="top: 0px;">
                    <img src="img/logo.png" class="logokadam p-1" alt="">
                </div>

            </div>
                <div class="font-weight-bold p-1 rounded-bottom border-radius-top marksheetcss hide">
                MARKSHEET
                </div>
            <div class="row">
                <div class="col-4" class="divBorder">
                    <p class="m-0 ml-1 p-1" style="line-height: 2;"><span style="font-weight: bold" class="hide">Exam Type:</span> Final Report
                        <!--  -->
                        <br> <span><b class="hide">Student's Name: </b> Sita Thapa </span>
                        <br> <span><b class="hide">Class: </b> Five</span>
                    </p>
                </div>
                <div class="col-4 rollmargin">
                    <p class="m-0 mr-1 " style="line-height: 2;"> <span><b class="hide">Roll No   :</b> 02</span>
                    </p>
                </div>
                <div class="col-4">
                    <p class="m-0 mr-1  p-1" style="line-height: 2;"> <span><b class="hide">Academic Year  : </b>2076</span>
                        <br> <span><b class="hide">Date of birth   : </b>2052-1-1</span>
                        <br> <span><b class="hide">Student's ID   :</b> s_12</span>
                    </p>
                </div>
            </div>
            <div class="tablepadding ">
                 <table class=" text-center table  removeborder" style="margin-bottom: 0px;">
                    <thead class="vAlignM bg-lightgreen hide">
                         <tr class="text-uppercase" >
                             <th rowspan="2" >SUBJECTs</th>
                             <th colspan="2">F.M</th>
                             <th colspan="2">P.M</th>
                             <th colspan="2"> 0.M</th>
                             <th colspan="5">Annual Evaluation</th>
                             <th rowspan="2">H.M</th>
                         </tr>
                         <tr>
                            <th>TH</th>
                            <th>PR</th> 
                            <th>TH</th>
                            <th>PR</th> 
                            <th>TH</th>
                            <th>PR</th> 
                            <th>10% unit test</th>
                            <th>20% 1st Term</th>
                            <th>20% 2nd Term</th>
                            <th>50% 3rd Term</th>
                            <th>TOTAL</th> 

                         </tr>
                         <tr>
                            
                             
                         </tr>
                    </thead>
                     <tbody >
                        <tr class="marksContainer" >
                            <td style="position: relative;"  >
                                <div class="backLogo hide" style="height: 100px">
                                    
                                </div>
                                <?php for($i=1;$i<=12;$i++){
                                                          
                                    echo "<p>$i</p>";
                                    }
                                ?>
                           </td>
                            <td>
                                <?php for($i=1;$i<=12;$i++){
                                                          
                                    echo "<p>$i</p>";
                                    }
                                ?>
                            </td>
                            <td>
                                <?php for($i=1;$i<=12;$i++){
                                                          
                                    echo "<p>$i</p>";
                                    }
                                ?>
                                
                            </td>
                            <td>
                                <?php for($i=1;$i<=12;$i++){
                                                          
                                    echo "<p>$i</p>";
                                    }
                                ?>
                                
                            </td>
                            <td>
                                <?php for($i=1;$i<=12;$i++){
                                                          
                                    echo "<p>$i</p>";
                                    }
                                ?>
                                
                            </td>
                            <td>
                                <?php for($i=1;$i<=12;$i++){
                                                          
                                    echo "<p>$i</p>";
                                    }
                                ?>
                                
                            </td>
                            <td>
                                <?php for($i=1;$i<=12;$i++){
                                                          
                                    echo "<p>$i</p>";
                                    }
                                ?>
                                
                            </td>
                            <td>
                                <?php for($i=1;$i<=12;$i++){
                                                          
                                    echo "<p>$i</p>";
                                    }
                                ?>
                                
                            </td>
                            <td>
                                <?php for($i=1;$i<=12;$i++){
                                                          
                                    echo "<p>$i</p>";
                                    }
                                ?>
                                
                            </td>
                            <td>
                                <?php for($i=1;$i<=12;$i++){
                                                          
                                    echo "<p>$i</p>";
                                    }
                                ?>
                                
                            </td>
                            <td>
                                <?php for($i=1;$i<=12;$i++){
                                                          
                                    echo "<p>$i</p>";
                                    }
                                ?>
                                
                            </td>
                            <td>
                                <?php for($i=1;$i<=12;$i++){
                                                          
                                    echo "<p>$i</p>";
                                    }
                                ?>
                                
                            </td>
                            <td>
                                <?php for($i=1;$i<=12;$i++){
                                                          
                                    echo "<p>$i</p>";
                                    }
                                ?>
                                
                            </td>

                        </tr>
                        <tr class="font-weight-bold">
                            <td rowspan="4" class="hide">Total</td>
                            <td colspan="2">100</td>
                            <td colspan="2">36</td>
                            <td colspan="2"> 60</td>

                              <!-- <td colspan="1"> 60</td>
                            <td colspan="1"> 60</td>
                             <td colspan="1"> 60</td>
                              <td colspan="1"> 60</td>
                               <td colspan="1"> 60</td>
                                <td colspan="1"> 100</td> -->

                            <td colspan="7">300</td>
                        </tr>
                        <tr>
                            
                        </tr>
                    </tbody>
                </table>
                 <div class="row  m-0 ">
                                <div class="col-5 divborder removeborder" style="border-right: 0;border-top: 0">
                                    <p>
                                       <b class="hide"> Class Teacher's Comments :</b> Try your best for next exam !!
                                    </p>
                                </div>
                                <div class="col-7 p-0">
                                    <table class=" text-center table removeborder border-top-0 m-0 " >
                                        <thead class="vAlignM">
                                            <tr>
                                                <th class="hide" style="border-top: 0!important">Result</th>
                                                <th style="width:100px;border-top: 0!important"></th>
                                                <th class="hide" style="border-top: 0!important">Annual Attendance</th>
                                                <th style="width:100px;border-top: 0!important"></th>
                                            </tr>
                                        </thead>
                                        <tbody class="vAlignM">
                                            <tr >
                                                <td  class="hide">Percentage</td>
                                                <td>60%</td>
                                                <td class="hide" >Conduct</td>
                                                <td >30</td>
                                            </tr>
                                             <tr >
                                                <td  class="hide">Division</td>
                                                <td>First</td>
                                                <td  class="hide">Dance</td>
                                                <td >50</td>
                                            </tr>
                                             <tr >
                                                <td class="hide" >Rank In Class</td>
                                                <td>5/50</td>
                                                <td class="hide" >Music</td>
                                                <td >50</td>
                                            </tr>
                                             <tr >
                                                <td  class="hide">Rank in Sec.</td>
                                                <td>1st</td>
                                                <td class="hide" >Art</td>
                                                <td >70</td>
                                            </tr>
                                             <tr >
                                                <td class="hide" >Term Attendance  </td>
                                                <td>60</td>
                                                <td class="hide" >Rhymes</td>
                                                <td >60</td>
                                            </tr>
                                        </tbody>
                                    </table>

                                </div>
                            </div>

            </div>
           
            
                
              
           
            <div class="row mt-5 px-5">
                
                <div class="col-6 " style="  position: relative;"> 
                    <span class="text-center hide" >         
                CLASS TEACHER
              </span>
                    <img src="img/sign.png" class="imgkada" style="top: -278%;
    right: 70%;">
                </div>
             
                <div class="col-6 text-right" style="position: relative;"> <span class="hide">         
                PRINCIPAL
              </span>
                    <img src="img/sign.png" class="imgkada" style="top: -271%;right: -5%">
                </div>
            </div>
            <div class="hide" style="margin: 0 5px;padding: 5px;">
                <div class="row bg-success  border-dark" style="margin: 0;padding: 8px;" >
                <div class="col-sm-10 bg-white border border-dark" style="padding: 0px;">
                     <table class=" text-center table   m-0" style="    table-layout: fixed;width: 995;">
                                        <thead class="vAlignM">
                                            <tr>
                                                <th>80% & Above</th>
                                                <th>60% Below 80%</th>
                                                <th>50% Below 60%</th>
                                                <th>40% Below 50%</th>
                                                 <th>Below 40%</th>
                                            </tr>
                                        </thead >
                                        <tbody class="vAlignM">
                                            
                                             <tr >
                                                <td >Distinction</td>
                                                <td>1st Division</td>
                                                <td >2nd Division</td>
                                                <td >3rd Division</td>
                                                <td >Fail</td>
                                            </tr>
                                            <tr >
                                                <td >A</td>
                                                <td>B</td>
                                                <td >C</td>
                                                <td >D</td>
                                                <td >E</td>
                                            </tr>
                                             <tr >
                                                <td >Distinction</td>
                                                <td>Excellent</td>
                                                <td >Good</td>
                                                <td >Average</td>
                                                <td >Poor</td>
                                            </tr>
                                        </tbody>
                                    </table>

                </div>
            </div>
            </div>
            <!-- <hr class="m-0"> -->
           <!--  <div class="row m-0">
                <div class="col-sm-9 p-0">
                    <h5 class="text-center m-0"><u>Explanation of grade</u></h5>
                    <table class="text-center table table-bordered  text-uppercase m-0">
                        <thead class="vAlignM">
                            <tr class="small">
                                <th>90%-100%</th>
                                <th>80%-
                                    <92%</th>
                                        <th>70%-
                                            <80%</th>
                                                <th>60%-
                                                    <70%</th>
                                                        <th>50%-
                                                            <60%</th>
                                                                <th>40%-
                                                                    <50%</th>
                                                                        <th>30%-
                                                                            <40%</th>
                                                                                <th>20%-
                                                                                    <30%</th>
                                                                                        <th>BELOW 20%</th>
                            </tr>
                        </thead>
                        <tbody class="vAlignM">
                            <tr>
                                <td>A+</td>
                                <td>A</td>
                                <td>B+</td>
                                <td>B</td>
                                <td>C+</td>
                                <td>C</td>
                                <td>D+</td>
                                <td>D</td>
                                <td>E</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-sm-3 p-0">
                    <h5 class="text-center m-0"><u>Key</u></h5>
                    <table class="text-center table table-bordered   text-uppercase  m-0">
                        <thead class="vAlignM">
                            <tr class="small">
                                <th>*</th>
                                <th>F</th>
                                <th>Ab</th>
                            </tr>
                        </thead>
                        <tbody class="vAlignM">
                            <tr>
                                <td>Distinction</td>
                                <td>Fail</td>
                                <td>Absent</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div> -->
        </div>
    </div>
    <!-- this pagebreak is required if page break in print -->
    <!-- <div class="pageBreak"></div> -->
</body>

</html>