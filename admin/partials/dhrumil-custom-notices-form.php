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
    function clean($string) {
       $string = str_replace('\s', '', $string); // Replaces all spaces with hyphens.
       return preg_replace('/[^0-9\-]/', '', $string); // Removes special chars.
    }
    
    $user_id = "";
    
    //echo $_GET["user_id"];
    //exit;
    
    $searchForValue = ',';
$stringValue = $_GET["user_id"];

if( strpos($stringValue, $searchForValue) !== false ) {
     //echo "Found";
     $epl = explode(",",$stringValue);
     
     
     
     ?>
      <div class="dhrunotcus-main-wrapper">
    <div class="dhrunotcus-instructions-wrap">
        <h1 style="margin:0;">
            Send Custom Notices to Users
        </h1>
    </div>
    
    <div class="dhrunotcus-instructions-wrap">
        <p style="font-size: 16px;">
            Please write a custom message in the message field and press the send button to send the notfication to the selected user. 
        </p>
        <p style="font-weight:700;">
            <?php
            foreach(array_filter($epl) as $runexpl){
     //echo $runexpl."<br/>";
     
     
                $user = get_userdata($runexpl);
            ?>
            Selected User: <?php echo $user->get("user_nicename"); ?> &lt;<?php echo $user->get("user_email"); ?> &gt;
            <br/>
        <?php } ?>
        </p>
    </div>
    
    <div class="dhrunotcus-form" style="">
        <form method="post">
            <textarea name="dhrunotcus_textarea" id="dhrunotcus-textarea" class="dhrunotcus-textarea" rows="10" cols="100"></textarea>
            <input type="hidden" name="_dhrunotcus_nonce" value="<?php echo wp_create_nonce("_dhrunotcus_form_nonce"); ?>">
            <input type="hidden" name="dhrunotcus_user_id" value="<?php echo $stringValue; ?>"/>
            <div class="dhrunotcus-form-button-wrapper">
                <input type="submit" name="dhrunotcus_submit2" value="Send Notice" class="dhrunotcus-form-btn dhrunotcus-form-submit-btn">
                <a href="admin.php?page=dhrumil-custom-notices" class="dhrunotcus-form-btn dhrunotcus-form-back-btn">Go Back</a>
            </div>
        </form>
    </div>
</div>
        
     
     
     <?php
}else if(isset($_GET["user_id"]))
    {
        $user_id = clean($_GET["user_id"]);
        ?>
        <div class="dhrunotcus-main-wrapper">
    <div class="dhrunotcus-instructions-wrap">
        <h1 style="margin:0;">
            Send Custom Notices to Users
        </h1>
    </div>
    
    <div class="dhrunotcus-instructions-wrap">
        <p style="font-size: 16px;">
            Please write a custom message in the message field and press the send button to send the notfication to the selected user. 
        </p>
        <p style="font-weight:700;">
            <?php
                $user = get_userdata($user_id);
            ?>
            Selected User: <?php echo $user->get("user_nicename"); ?> &lt;<?php echo $user->get("user_email"); ?> &gt;
        </p>
    </div>
    
    <div class="dhrunotcus-form" style="">
        <form method="post">
            <textarea name="dhrunotcus_textarea" id="dhrunotcus-textarea" class="dhrunotcus-textarea" rows="10" cols="100"></textarea>
            <input type="hidden" name="_dhrunotcus_nonce" value="<?php echo wp_create_nonce("_dhrunotcus_form_nonce"); ?>">
            <input type="hidden" name="dhrunotcus_user_id" value="<?php echo $user->get("ID"); ?>"/>
            <div class="dhrunotcus-form-button-wrapper">
                <input type="submit" name="dhrunotcus_submit" value="Send Notice" class="dhrunotcus-form-btn dhrunotcus-form-submit-btn">
                <a href="admin.php?page=dhrumil-custom-notices" class="dhrunotcus-form-btn dhrunotcus-form-back-btn">Go Back</a>
            </div>
        </form>
    </div>
</div>
        
        <?php
    }
    else
    {
        echo "Please Select a user from the main page first!";
        echo "<a href='admin.php?page='".$this->plugin_name."'>Go Back</a>";
    }
?>