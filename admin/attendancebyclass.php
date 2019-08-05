<?php
include('session.php');
require("../important/backstage.php");

   $backstage = new back_stage_class();

/*set active navbar session*/
$_SESSION['navactive'] = 'attendancebyclass';

  $year_id = $current_year_session_id;

  $classList= json_decode($backstage->get_class_list_by_year_id($year_id));
   

        
    if (isset($_GET["atbyclassview"])) { 
        
        if (isset($_GET["setclass"]) && isset($_GET["setsec"])) {
          $searchclass = addslashes($_GET["setclass"]);
          $searchsection = addslashes($_GET["setsec"]);
                
                $query = $db->query("SELECT * FROM abcheck where `abclass` = '$searchclass' and `absec` = '$searchsection'");
                $rowCount = $query->num_rows;
                if($rowCount > 0) { $found='1';} else{ $found='0';   }

                $csname= json_decode($backstage->get_class_section_name_by_id($searchclass,$searchsection));
        } 
    }         
?>
        <!-- add adminheade.php here -->
    <?php include_once("../config/header.php");?>
    <?php include_once("navbar.php");?>

    <script>
    function showUser(str) {
      if (str == "") {
          document.getElementById("txtHint").innerHTML = "";
          return;
      } else { 
          if (window.XMLHttpRequest) {
              // code for IE7+, Firefox, Chrome, Opera, Safari
              xmlhttp = new XMLHttpRequest();
          } else {
              // code for IE6, IE5
              xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
          }
          xmlhttp.onreadystatechange = function() {
              if (this.readyState == 4 && this.status == 200) {
                  var selectDropdown =    $("#txtHint");
                  document.getElementById("txtHint").innerHTML = this.responseText;
                  selectDropdown.trigger('contentChanged');
              }
          };
          xmlhttp.open("GET","../important/getListById.php?classforsection="+str,true);
          xmlhttp.send();
          $('select').on('contentChanged', function() { 
          // re-initialize 
         $(this).material_select();
           });
      }
    }
    </script>
    <script type="text/javascript">
        function validate(form) {
          var e = form.elements, m = '';

              if(!e['class'].value) {m += '- Select Class.\n';}
              if(!e['txtHint'].value) {m += '- Select section.\n';}
              
              if(m) {alert('The following error(s) occurred:\n\n' + m);
                return false;
              }else
              return true;
            }
        </script>
    
            <main>
                <div class="section no-pad-bot" id="index-banner">
                <?php include_once("../config/schoolname.php");?>
                <div class="github-commit">
                        <div class="container">
                            <div class="row center"><a class="white-text text-lighten-4">Attendance By Class</a></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m12">
                        <div class="card grey darken-3">
                            <div class="card-content white-text">
                                <span class="card-title flow-text"><span style="color:#009fff;">Search</span></span>
                                <div class="row">
                                    <form class="col s12" action="returnsearchdate.php?byclass" method="post" onsubmit="return validate(this);">
                                        <div class="row">
                                            <div class="input-field col s12">
                                                <select name="classsearch" id="class" onchange="showUser(this.value)" >
                                                <option value="" >Select class</option>
                                                <?php 
                                                foreach ($classList as $clist) {
                                                      echo '<option value="'.$clist->class_id.'"> ' . $clist->class_name. ' </option>';
                                                }
                                                ?>
                                            </select>
                                            <label>Select Class</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="input-field col s12">
                                                <select name="sectionsearch" id="txtHint">
                                                <option value="" >Select class first</option>
                                              </select>
                                              <label>Section:</label>
                                            </div>
                                        </div>
                                        <button class="btn waves-effect waves-light blue lighten-2" type="submit" name="action"><i class="material-icons right">search</i>Search</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>

                <?php
                        if($found == '1'){
                            ?>
                    <div class="row">
                        <div class="col s12 m6">
                                    <div class="container">
                                        <table class="centered bordered highlight z-depth-4">
                                            <thead>
                                                <tr>
                                                    <th colspan="4">Attendance Report For Class <?php echo $csname->class_name."-".$csname->section_name;?></th>
                                                </tr>
                                                <tr>
                                                    <th>Date</th>
                                                    <th>Present</th>
                                                    <th>Absent</th>
                                                    <th>Info.</th>
                                                </tr>
                                            </thead>

                                            <?php while($row = $query->fetch_assoc()){ ?>
                                                <tr>
                                                    <td>
                                                        <?php echo (($login_date_type==2)? eToN($row["abdate"]) : $row["abdate"]);?>
                                                    </td>
                                                    <td>
                                                        <?php echo $row["abpcount"];?>
                                                    </td>
                                                    <td>
                                                        <?php echo $row["abacount"];?>
                                                    </td>
                                                    <td>
                                                        <a href="alistview.php?atbyclass&extraclass=<?php echo $searchclass;?>&extrasec=<?php echo $searchsection;?>&extradate=<?php echo (($login_date_type==2)? eToN($row["abdate"]) : $row["abdate"]);?>"><span class="white-text text-lighten-2" style="font-weight: 400;vertical-align:middle; display: inline-flex; padding-bottom: 3px;"><i class="material-icons blue-text">info_outline</i>&nbsp;</span></a>
                                                    </td>
                                                </tr>
                                                <?php } ?>
                                        </table>

                                    </div>
                                </div>
                            </div>
                    <?php
                                            } else if($found == '0') { ?>
                        <div class="row">
                            <div class="col s12 m6">
                                <div class="card grey darken-3">
                                    <div class="card-content white-text">
                                        <span class="card-title"><span style="color:#80ceff;">No results found</span></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php } ?>

            </main>


            <?php include_once("../config/footer.php");?>