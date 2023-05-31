<?php 
add_action( 'wpcf7_mail_sent', 'your_wpcf7_mail_sent_function' ); 
function your_wpcf7_mail_sent_function( $contact_form ) {
	foreach ($_COOKIE as $key=>$val) {
		if (strpos($key, '_pk_id') !== false) {
		  $keyName=$key;
	  }
	  }
	  
	  $value=$_COOKIE[$keyName];
	  $keyArr=explode("_",$keyName);
	  $accountId=$keyArr[3];
	  $valArr=explode(".",$value);
	  $visitorId=$valArr[0];
	  $sessionId=$valArr[1];
	  $visit=$valArr[2];

    $submission = WPCF7_Submission::get_instance();  
    if ( $submission ) {
        $posted_data = $submission->get_posted_data();
    }       
        $contactName = $posted_data['your-name'];
        $email = $posted_data['your-email'];
		$phoneNumber = $posted_data['phone'];
		$companyName = $posted_data['company'];
		$comment = $posted_data['comment'];
		$pageUrl="https://hubspireonline.staging.wpengine.com/contact/";



	$str_post = "contactName=" . urlencode($contactName).
	"&accountId=".urlencode($accountId) .
	"&visitorTrackingId=".urlencode($visitorId) .
	"&sessionId=".urlencode($sessionId) .
	"&visit=".urlencode($visit) .
	"&email=".urlencode($email) .
	"&phoneNumber=" .urlencode($phoneNumber) .
	"&comment=" .urlencode($comment) .
	"&pageUrl=" .urlencode($pageUrl) .
	"&companyName=".urlencode($companyName);
	
	  $endpoint = 'http://35.182.231.171:3010/api/contacts/contactSubmit';
	  
	  $ch = @curl_init();
	  @curl_setopt($ch, CURLOPT_POST, true);
	  @curl_setopt($ch, CURLOPT_POSTFIELDS, $str_post);
	  @curl_setopt($ch, CURLOPT_URL, $endpoint);
	  @curl_setopt($ch, CURLOPT_HTTPHEADER, array(
	   'Content-Type: application/x-www-form-urlencoded'
	  ));
	  @curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	  $response    = @curl_exec($ch); //Log the response from HubSpot as needed.
	  $status_code = @curl_getinfo($ch, CURLINFO_HTTP_CODE); //Log the response status code
	  @curl_close($ch);
}
