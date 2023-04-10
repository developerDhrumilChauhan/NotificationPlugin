jQuery(document).on("ready", function($){
	//alert("hello");
    function checkForNewNotices(){
        jQuery.ajax({
            url: dcn_ajax.ajax_url,
            dataType: 'json',
            data: {action: 'checkForNewNotices'},
            success:function(d){
                response = JSON.parse(d);
                if(response != 0){
                    if(!alert("There are new notices available. You will now be redirected to the notices page shortly")){
                        //window.location.href = "https://techguyswa.com.au/wavetgolf/notices/";
                        window.location.href = "https://wavetgolf.org/notice/";
                    }
                }
            },
            error:function(d,c,n){
				window.location.href = "https://wavetgolf.org/";
                //alert('There has been an error fetching data, error details:\n'+d+'\n'+c+'\n'+n)
            }
        });
    }
    //setInterval(checkForNewNotices, 5000);
});