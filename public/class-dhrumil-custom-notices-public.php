<?php

/**
 * @package    Dhrumil_Custom_Notices
 * @subpackage Dhrumil_Custom_Notices/public
 * @author     Dhrumil Chauhan <dhrumilchauhan708@gmail.com>
 */

class Dhrumil_Custom_Notices_Public {

	private $plugin_name;
	private $version;
	private $public_ajax_handle;

	public function __construct( $plugin_name, $version ) {
		
		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->public_ajax_handle = "dcn_ajax_public";
	}

	public function enqueue_styles() {
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/dhrumil-custom-notices-public.css', array(), $this->version, 'all' );
	}

	public function enqueue_scripts() {
	    if(is_user_logged_in()){
		    wp_register_script($this->public_ajax_handle, plugin_dir_url( __FILE__ ) . 'js/dhrumil-custom-notices-public.js', array( 'jquery' ));
		    wp_localize_script( 
		        $this->public_ajax_handle, 
		        'dcn_ajax', 
		        array(
		            'ajax_url' => admin_url("admin-ajax.php")
		            )
	        );
		    wp_enqueue_script($this->public_ajax_handle);
		}
	}
	
	public function checkForNewNotices(){
	    global $wpdb;
        $currUser = get_current_user_id();
        $sql = "select seen from ".$wpdb->prefix."dcn_notices where user_id = %d and seen = %d";
        $sqlResult = $wpdb->get_results($wpdb->prepare($sql, $currUser, 0), "ARRAY_A");
        
        if(count($sqlResult) > 0){
            echo json_encode(1, JSON_NUMERIC_CHECK);
            die();
        }
        
        echo json_encode(0, JSON_NUMERIC_CHECK);
        die();
	}
	
	public function dcn_notices_callback(){
	    if(is_user_logged_in()){
	        global $wpdb;
	        $user_id = get_current_user_id();
	        if ( is_front_page() ) {    
	        $sql = "select ID,notices, seen from ".$wpdb->prefix."dcn_notices where user_id = %d order by ID desc LIMIT 1";
	        
	         if(isset($_REQUEST['did'])){
	            echo "<script> alert('Message Deleted Successfully'); </script>";
	            $get_did = $_REQUEST['did'];
	            
	            global $wpdb;
     $table_name = $wpdb->prefix.'dcn_notices';
     $wpdb->query( 
 $wpdb->prepare( 
    "
            DELETE FROM $table_name WHERE ID = %d",
      $get_did
    )
);
header("Location: https://wavetgolf.org/");
die();
	            //echo "<h1>HELLO</h1>";
	           // exit;
	        }
	        } else{
	             if(isset($_REQUEST['did'])){
	            echo "<script> alert('Message Deleted Successfully'); </script>";
	            $get_did = $_REQUEST['did'];
	            
	            global $wpdb;
     $table_name = $wpdb->prefix.'dcn_notices';
     $wpdb->query( 
 $wpdb->prepare( 
    "
            DELETE FROM $table_name WHERE ID = %d",
      $get_did
    )
);
header("Location: https://wavetgolf.org/notice/");
die();
	            //echo "<h1>HELLO</h1>";
	           // exit;
	        }
	             $sql = "select ID,notices, seen from ".$wpdb->prefix."dcn_notices where user_id = %d order by ID desc";
	            
	        }
	        //echo $sql."<br>".$user_id;
	        $result = $wpdb->get_results($wpdb->prepare($sql, $user_id), "ARRAY_A");
	       // print_r($result);
	        
	       
	        $reset_notice_status_flag = false;
	        // 
	        if(!empty($result)){
	       
	             if ( is_front_page() ) {    
	        echo "
	        <br/><div style=' border: 2px solid #949494; background:white; border-radius:5px;width:600px; float: right; padding:20px;box-shadow: 1px 7px 10px #767676;'><h2>Notices</h2><div style='border:2px solid blue; border-radius:5px; width:550px; padding:20px'>";
	       
	        
	        foreach($result as $row)
	        {
	            $del_id = $row["ID"];
	            
	            ?>
	            
	 <div class='dhrucusnot-notice'><span class='msg_text'><?php
	 

$in = $row["notices"];
	 $out = strlen($in) > 30 ? substr($in,0,30)."..." : $in;
	 
	 if($row["notices"] == ""){ echo "0 Notice found";} 
	 else{  //echo $row["notices"]; 
	 echo $out;
	 }?></span> &nbsp; <span  class="text_right"><a href='https://wavetgolf.org?did=<?php echo $del_id; ?>' >
	 <!-- <img src="https://wavetgolf.org/wp-content/uploads/2022/01/New-Project-1.png" style="float:right" /> -->
		<button type='button' style="background-color:#86d2f4; border-radius:5px; color:#fff; float:right;">Delete</button></a></span></div> 
	 <?php
	 
	     if ( is_front_page() ) { 
	 echo "<a href='https://wavetgolf.org/notice/' style='color:blue!important'>Read More >> </a>";
	 
	     }
	     ?>       
	           <?php
	            
	            if($reset_notice_status_flag != true){
	                if($row[seen] == 0){
	                    $reset_notice_status_flag = true;
	                }   
	            }
	        }
	        echo "</div>";
	             } else{
	                 
	               echo "   <br/><center><div style='border: 2px solid #949494;background:white;border-radius:5px;width: 100%;padding:20px;box-shadow: 1px 7px 10px #767676;'><h2>Notices</h2><div style='border:2px solid blue; border-radius:5px; width:100%; padding:20px'>";
	        foreach($result as $row)
	        {
	            $del_id = $row["ID"];
	            ?>
	 <div class='dhrucusnot-notice2' style="width:90%"><span class=''>
	     <table>
	         <tr>
	             <td style="width:80%">
	                  <?php $n_var = $row["notices"]; if(empty($n_var)){ echo "0 Notice found";} else{ 
	                      //echo "hello";
	                      echo $row["notices"]; 
	                  }?></span> 
	             </td>
	             <td><span  class=""><a href='https://wavetgolf.org/notice?did=<?php echo $del_id; ?>' ><img src="https://wavetgolf.org/wp-content/uploads/2022/01/New-Project-1.png" style="float:right" /></a></span></td>
	         </tr>
	     </table>
	    </div> 
	 <?php
	 
	     if ( is_front_page() ) { 
	 echo "<a href='https://wavetgolf.org/notice/' >Read More >> </a>";
	 
	     }
	     ?>       
	           <?php
	            
	            if($reset_notice_status_flag != true){
	                if($row[seen] == 0){
	                    $reset_notice_status_flag = true;
	                }   
	            }
	        }
	        echo "</div></center>";
	                 
	             }
	             
	    }
	        if($reset_notice_status_flag == true){
	           $sql_to_normalize = "update ".$wpdb->prefix."dcn_notices set seen = 1 where user_id = %d and seen = 0";
	           if(!$wpdb->query($wpdb->prepare($sql_to_normalize, $user_id))){
	               echo "There Has been some error retrieving the notices! Please report this to the Admin with a Screenshot.";
	           }
	        }
	        
	        //echo gettype($result);
	        //print_r($result);
	        
	    }
	}
	
	public function add_notice_shortcode(){
	    add_shortcode("dcn_notices", array($this, "dcn_notices_callback"));
	} 
	
		
	public function dcn_notices_div(){
	    echo "HELLO";
	    
	}
	
		public function add_notice_div(){
	    add_shortcode("dcn_notices_div", array($this, "dcn_notices_div"));
	} 
	
	
	
	
	public function dcn_notices_callback_home(){
	    if(is_user_logged_in()){
	        global $wpdb;
	        $user_id = get_current_user_id();
	        $sql = "select ID,notices, seen from ".$wpdb->prefix."dcn_notices where user_id = %d order by ID desc";
	        //echo $sql."<br>".$user_id;
	        $result = $wpdb->get_results($wpdb->prepare($sql, $user_id), "ARRAY_A");
	        $reset_notice_status_flag = false;
	        // 
	        
	        if(isset($_REQUEST['did'])){
	            echo "<script> alert('Message Deleted Successfully'); </script>";
	            $get_did = $_REQUEST['did'];
	            
	            global $wpdb;
     $table_name = $wpdb->prefix.'dcn_notices';
     $wpdb->query( 
 $wpdb->prepare( 
    "
            DELETE FROM $table_name WHERE ID = %d",
      $get_did
    )
);
header("Location: https://wavetgolf.org/");
die();
	            //echo "<h1>HELLO</h1>";
	           // exit;
	        }
	        
	        echo "<br/><center><h2 style='border: 2px solid #949494;border-radius:5px;width:550px;padding:20px;box-shadow: 1px 7px 10px #767676;'>Notices</h2><div style='border:2px solid blue; border-radius:5px; width:550px; padding:20px'>";
	        foreach($result as $row)
	        {
	            $del_id = $row["ID"];
	            ?>
	 <div class='dhrucusnot-notice'><span class='msg_text'><?php echo $row["notices"]; ?></span> &nbsp; <span  class="text_right"><a href='https://wavetgolf.org?did=<?php echo $del_id; ?>' ><img src="https://wavetgolf.org/wp-content/uploads/2022/01/New-Project-1.png" style="float:right" /></a></span></div> 
	            
	           <?php
	            
	            if($reset_notice_status_flag != true){
	                if($row[seen] == 0){
	                    $reset_notice_status_flag = true;
	                }   
	            }
	        }
	        echo "</div></center>";
	        if($reset_notice_status_flag == true){
	           $sql_to_normalize = "update ".$wpdb->prefix."dcn_notices set seen = 1 where user_id = %d and seen = 0";
	           if(!$wpdb->query($wpdb->prepare($sql_to_normalize, $user_id))){
	               echo "There Has been some error retrieving the notices! Please report this to the Admin with a Screenshot.";
	           }
	        }
	        
	        //echo gettype($result);
	        //print_r($result);
	        
	    }
	}
	
	public function add_notice_shortcode_home(){
	    add_shortcode("dcn_notices_home", array($this, "dcn_notices_callback_home"));
	} 
	
	
	public function check_for_new_notices(){
	    global $wpdb;
	    $user_id = get_current_user_id();
	    $flag = 0;
	    $sql = "select count(seen) from ".$wpdb->prefix."dcn_notices where user_id = %d and seen = %d";
	    $results = $wpdb->get_results($wpdb->prepare($sql, $user_id, $flag), 'ARRAY_A');
	    $newNotificationsCount = $results[0];
	    
	    if( $newNotificationsCount["count(seen)"] > 0){
	        wp_redirect(home_url("/notice"));
	        exit();
	    }
	}

}