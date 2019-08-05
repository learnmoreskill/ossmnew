<!-- Modal Structure -->
<?php
    $academic_year_for_session = $db->query("SELECT * FROM `academic_year` WHERE `status`=0 ORDER BY `single_year`");
?>
  <div id="modal_change_current_session" class="modal" style="overflow: visible;">
    <div class="modal-content cPadding">
      <form id="update_current_session_year_form" >
        <h6 align="center">Change Session</h6>
        <div class="divider"></div>

        <div class="row noMargin">
          <div class="col s3 m2 offset-m1">
              <h6 style="padding-top: 20px">Session</h6>
          </div>
            <div class="input-field col s6 selected_session_year_Container">
                <select name="selected_session_year_id" >
                    <option value="" disabled>Select year</option>
                    <?php if ($academic_year_for_session->num_rows > 0) {
                        while($row_y_s_list = $academic_year_for_session->fetch_assoc()) { ?>
                            <option value="<?php echo $row_y_s_list['id'];?>"
                                <?php echo (($row_y_s_list['id']==$current_year_session_id)?'selected="selected"':''); ?>
                                ><?php echo $row_y_s_list['year']; ?></option>

                            <?php
                        }
                    } ?>
                </select>
                <label>Select year</label>
            </div>
        </div>
        <input type="hidden" name="update_current_session_year" value="update_current_session_year" >
        <div class="modal-footer">
          <button class="modal-action  waves-effect waves-green btn-flat blue lighten-2" type="submit" >Save<i class="material-icons right">send</i></button>
        </div>

    </form>
    </div>
  </div>