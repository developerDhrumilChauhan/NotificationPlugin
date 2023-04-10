<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://www.dhrumilcustomnotices.com
 * @since      1.0.0
 *
 * @package    Dhrumil_Custom_Notices
 * @subpackage Dhrumil_Custom_Notices/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<?php
    $user_arr = get_users();
    
?>

<div class="dhrunotcus-main-wrapper">
    
    <div class="dhrunotcus-instructions-wrap">
        <h1 style="margin:0;">
            Send Custom Notices to Users 
        </h1>
    </div>
    
    <div class="dhrunotcus-instructions-wrap">
        <p style="font-size: 16px;">
            Please click on the "Send Notice" button to send a personalised notice to your users. Hit "Ctrl" + "F" to find users.
        </p>
    </div>
    <table id="dhrunotcus-users-table">
        <thead class="dhrunotcus-users-table-header">
            <tr class="dhrunotcus-users-table-row">
            
            <th width="100px">
                   Select
                </th>
                <th width="100px">
                    ID
                </th>
                <th>
                    Name
                </th>
                <th>
                    Email
                </th>
                <th width="300px">
                    Action
                </th>
            </tr>
        </thead>
        <tbody class="dhrunotcus-users-table-body">
            <?php
                $i = 1;
                foreach($user_arr as $user)
                {   
                    echo "<tr class='dhrunotcus-users-table-row' height='50px'>";
                    echo "<td><input type='checkbox' name='dhruchk[]' value='".$user->get("ID")."' /> </td>";
                    echo "<td>".$i."</td>";
                    echo "<td>".$user->get("user_nicename")."</td>";
                    echo "<td>".$user->get("user_email")."</td>";
                    echo "<td>
                        <a href='admin.php?page=dhrumil-custom-notices&dcn_page=form&user_id=".$user->get("ID")."'>Send a Notice</a>
                        <a href='admin.php?page=dhrumil-custom-notices&dcn_page=notice-history&user_id=".$user->get("ID")."'>History</a>
                    </td>";
                   echo "</tr>";
                    $i++;
                }
            ?> 
            <div class="action_buttons">
                <div id="actbtn" style="background:#ccc; padding:10px; border-radius:10px; color:#000; font-weight:bold; cursor:pointer; width:200px; text-align:center">Send Notice To Selected User</div>
                <!-- Display All Notice -->
                <div id="sanbtn" style="background:#ccc; padding:10px; border-radius:10px; color:#000; font-weight:bold; cursor:pointer; width:200px; text-align:center">See all notice</div>
            </div>
            
        </tbody>
    </table>
</div>
<script>

jQuery("#actbtn").click( function(e){
  e.preventDefault();
    var sList = "";
    jQuery('input[name="dhruchk[]"]').each(function () {
        if(this.checked){
            sList +=  jQuery(this).attr('value') + ",";
        }
    });
   // alert(sList);
   if(sList != ""){
    jQuery("#actbtn").attr("href","admin.php?page=dhrumil-custom-notices&dcn_page=form&user_id="+sList);
    window.location.href = "https://wavetgolf.org/wp-admin/admin.php?page=dhrumil-custom-notices&dcn_page=form&user_id="+sList;
   } else{
       alert("Please Select Users");
   }
//alert("ok");
});

// See all Sent notice
jQuery('#sanbtn').click( function(e){
    e.preventDefault();

    jQuery("#sanbtn").attr("href","admin.php?page=dhrumil-custom-notices&dcn_page=form");
    window.location.href = "<?php echo site_url(); ?>/wp-admin/admin.php?page=dhrumil-custom-notices&dcn_page=notice-history";
} );
</script>