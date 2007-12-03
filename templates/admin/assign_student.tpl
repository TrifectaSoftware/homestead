{START_FORM}
<div class="hms">
  <div class="box">
    <div class="{TITLE_CLASS}"><h1>{TITLE}</h1></div>
    <div class="box-content">
        <!-- BEGIN error_msg -->
        <font color="red">{ERROR_MSG}<br /></font>
        <!-- END error_msg -->
        
        <!-- BEGIN success_msg -->
        <font color="green">{SUCCESS_MSG}<br /></font>
        <!-- END success_msg -->
        
        {MESSAGE}<br /><br />
        <table>
            <tr>
                <th align="left">ASU Email:</th><td>{USERNAME}@appstate.edu</td>
            </tr>
            <tr>
                <th align="left">{RESIDENCE_HALL_LABEL}</th>
                <td>{RESIDENCE_HALL}</td>
            </tr>
                <th align="left">{FLOOR_LABEL}</th>
                <td>{FLOOR}</td>
            <tr>
                <th align="left">{ROOM_LABEL}</th>
                <td>{ROOM}</td>
            </tr>
                <th align="left">{BEDROOM_LABEL}</th>
                <td>{BEDROOM}</td>
            <tr>
                <th align="left">{BED_LABEL}</td>
                <td>{BED}</td>
            </tr>
        </table>
        <br />
        {SUBMIT}
    </div>
  </div>
</div>
{END_FORM}
