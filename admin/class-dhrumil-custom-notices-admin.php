<?php

/**
 * @package    Dhrumil_Custom_Notices
 * @subpackage Dhrumil_Custom_Notices/admin
 * @author     Dhrumil Chauhan <dhrumilchauhan708@gmail.com>
 */

class Dhrumil_Custom_Notices_Admin {

	private $plugin_name;
	private $version;
	private $page_title;
	private $menu_title;

	public function __construct( $plugin_name, $version, $page_title, $menu_title ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->page_title = $page_title;
		$this->menu_title = $menu_title;
	}

	public function enqueue_styles() {

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/dhrumil-custom-notices-admin.css', array(), $this->version, 'all' );

	}

	public function enqueue_scripts() {

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/dhrumil-custom-notices-admin.js', array( 'jquery' ), $this->version, false );

	}
	
	public function create_admin_menu_link(){
		add_menu_page($this->page_title, $this->menu_title, 'manage_options', $this->plugin_name, array($this, 'render_admin_pages'));
	}
    
    public function add_custom_user_action( $actions, $user ) {
        $actions['send_notice'] = "<a class='send_notice' href='admin.php?page=".$this->plugin_name."&dcn_page=form&user_id=".$user->ID."'>Send A Notice</a>";
        return $actions;
    }
    
	public function render_admin_pages(){
	    
	    if(isset($_POST["dhrunotcus_submit"])){
	        if(wp_verify_nonce( $_POST["_dhrunotcus_nonce"], "_dhrunotcus_form_nonce")){
	            global $wpdb;
	            $dcn_message = $_POST["dhrunotcus_textarea"];
	            $dcn_user_id = $_POST["dhrunotcus_user_id"];
                
	            $status_flag = 0;
	            
	             $user_info = get_userdata($dcn_user_id);
                $mailadresje = $user_info->user_email;
                
                 $to_email = $mailadresje;
   $subject = "Notice for You from wavetgolf.org";
   $body = $dcn_message;
   $headers = "From: secretary@wavetgolf.org";

   if ( mail($to_email, $subject, $body, $headers)) {
      //echo("Email successfully sent to $to_email...");
   } else {
     // echo("Email sending failed...");
   }
                
	            
	            $sql = "insert into ".$wpdb->prefix."dcn_notices (user_id, notices, seen) values(%d, %s, %d)";
	            $parameters = array($dcn_user_id, $dcn_message, $status_flag);
	            if($wpdb->query($wpdb->prepare($sql, $parameters)))
	            {
	                echo "<p style='background: #15a615;color: #fff;font-size: 26px;padding: .34rem 1em;border-radius: 100px;'>Success! Message sent</p>";
	            }
	            else{
	                echo "<p style='background: #ff3f14;color: #fff;font-size: 26px;padding: .34rem 1em;border-radius: 100px;'>Error! Message not sent</p>";
	            }
	        }
	    }
        
        
          if(isset($_POST["dhrunotcus_submit2"])){
	        if(wp_verify_nonce( $_POST["_dhrunotcus_nonce"], "_dhrunotcus_form_nonce")){
	            global $wpdb;
	            $dcn_message = $_POST["dhrunotcus_textarea"];
	            $dcn_user_id = $_POST["dhrunotcus_user_id"];
                $explode = explode(",",$dcn_user_id);
                
                foreach(array_filter($explode) as $floop){
                    
                   //echo $floop."<Br/>";
                   //echo $dcn_user_id;
                    //exit;
                    $user_info = get_userdata($floop);
                $mailadresje = $user_info->user_email;
                
                
                 $to_email = $mailadresje;
   $subject = "Notice for You from wavetgolf.org";
   $body = $dcn_message;
   $headers = "From: secretary@wavetgolf.org";

   if ( mail($to_email, $subject, $body, $headers)) {
      //echo("Email successfully sent to $to_email...");
   } else {
     // echo("Email sending failed...");
   }
                    
                    
                 $status_flag = 0;
	            $sql = "insert into ".$wpdb->prefix."dcn_notices (user_id, notices, seen) values(%d, %s, %d)";
	            $parameters = array($floop, $dcn_message, $status_flag);
	            $wpdb->query($wpdb->prepare($sql, $parameters));
	            /*if($wpdb->query($wpdb->prepare($sql, $parameters)))
	            {
	                echo "<p style='background: #15a615;color: #fff;font-size: 26px;padding: .34rem 1em;border-radius: 100px;'>Success! Message sent</p>";
	            }
	            else{
	                echo "<p style='background: #ff3f14;color: #fff;font-size: 26px;padding: .34rem 1em;border-radius: 100px;'>Error! Message not sent</p>";
	            }*/
                }
	           echo "<p style='background: #15a615;color: #fff;font-size: 26px;padding: .34rem 1em;border-radius: 100px;'>Success! Message sent</p>";
	        }
	    }
	    
	    if(isset($_GET['dcn_page'])){
	        if($_GET['dcn_page'] == "home")
		        require_once plugin_dir_path( __FILE__ ) . "partials/dhrumil-custom-notices-admin-display.php";
		    else if($_GET['dcn_page'] == "form")
		        require_once plugin_dir_path( __FILE__ ) . "partials/dhrumil-custom-notices-form.php";
			else if($_GET['dcn_page'] == "notice-history")
		        require_once plugin_dir_path( __FILE__ ) . "partials/dhrumil-custom-notices-history-display.php";
	    }
	    else{
	        require_once plugin_dir_path( __FILE__ ) . "partials/dhrumil-custom-notices-admin-display.php";
	    }
	}

}