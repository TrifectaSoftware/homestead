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
            <td>{SUBMIT}</td>
            <td>{CANCEL}</td>
          </tr>
        </table>
    </div>
  </div>
</div>
{END_FORM}
