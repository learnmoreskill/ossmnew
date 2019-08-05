<header class="header black-bg" style="background: #252423;display: inline-flex;">
    <div class="sidebar-toggle-box">
        <div class="fa fa-bars tooltips" data-placement="right" data-original-title="Toggle Navigation"></div>
    </div>
    <!--logo start-->
    <div>
      <a  href="../index.php" class="logo navTitleHead"><b><?php echo $school_details->school_name; ?></b></a>
      
    </div>
    <!--logo end-->
    <div class="search-box test3 input-field col s12 m12" style="margin: auto 0 auto auto;min-width: 252px">

        <input id="searchname" autocomplete="off" name="searchname" type="text" class="validate" placeholder="Search Student" style="width: 200px;height: 28px">
          <span class="input-group-addon clearIcon" onclick="clearSearch()">X</span>

        <div class="result resultStyle studListSelection"></div>
    </div>                                      
                                      
</header>
<script type="text/javascript">
$(document).ready(function(){
  $("#searchname").keyup(function() {
    $('.search-box input[type="text"]').on("keyup input", function(){
    return "active";
  });
      
        /* Get input value on change */
        var inputVal = $(this).val();
        var resultDropdown = $(this).siblings(".result");
        if(inputVal.length){ 
            $.get("../../admin/backend-search.php", {allStudent: inputVal}).done(function(data){

                data=JSON.parse(data);
                var temparr='';
                data.forEach(function(value){
                  temparr += "<p class='stList "+((value.status!=0)? 'colorRed':'')+"  '     >"+value.sname+"&nbsp&nbsp Class: "+value.class_name+"-"+value.section_name+"&nbsp&nbsp Roll: "+value.sroll+"<span id='studData' style='display:none;'>"+JSON.stringify(value)+"</span></P>"

                });
                  resultDropdown.html(temparr);

            });
        } else{
                resultDropdown.empty();
              
        }
    });
    
    // Set search input value on click of result item
    $(document).on("click", ".result p", function(){

        var sName=$(this).parents(".search-box").find('input[type="text"]').val(this.innerText);

        var sData = this.getElementsByTagName('span')[0].innerHTML;                
        sData=JSON.parse(sData);
        
        console.log("data received",sData.sname);
        window.location.href='../student/fee-collection.php?student_id='+sData.sid;
    });
     
});
function clearSearch(){
    document. getElementById('searchname'). value = '';
    $("div.result").html('');
}
</script>