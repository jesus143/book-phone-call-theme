<?php
/*-----------------------------------------------------------------------------------*/
/* Options Framework Functions
/*-----------------------------------------------------------------------------------*/
/* Set the file path based on whether the Options Framework is in a parent theme or child theme */
if ( STYLESHEETPATH == TEMPLATEPATH ) {
    define('OF_FILEPATH', TEMPLATEPATH);
    define('OF_DIRECTORY', get_bloginfo('template_directory'));
} else {
    define('OF_FILEPATH', STYLESHEETPATH);
    define('OF_DIRECTORY', get_bloginfo('stylesheet_directory'));
}

/* These files build out the options interface.  Likely won't need to edit these. */
require_once (OF_FILEPATH . '/admin/admin-functions.php');		// Custom functions and plugins
require_once (OF_FILEPATH . '/admin/admin-interface.php');		// Admin Interfaces (options,framework, seo)

/* These files build out the theme specific options and associated functions. */
require_once (OF_FILEPATH . '/admin/theme-options.php'); 		// Options panel settings and custom settings
require_once (OF_FILEPATH . '/admin/theme-functions.php'); 	// Theme actions based on options settings

//add support for featured images
add_theme_support( 'post-thumbnails' );
set_post_thumbnail_size(120);


//Get Partner's Info
$path = $_SERVER["REQUEST_URI"];
$preg = preg_split('/[^a-z0-9]/', $path);
foreach ($preg  as $key => $namee) {
    if(($key == 3) && ($namee != '')) {
        $partner_id = $namee;
    }
}


$mydb = new wpdb('dbo640728737','1qazxsw2!QAZXSW@','db640728737','db640728737.db.1and1.com');
$rows = $mydb->get_results("SELECT * FROM wp_user_profiles_mirror WHERE partner_id = ".$partner_id."");
foreach ($rows as $obj) :
    $partner_id = $obj->partner_id;
    $company_name = $obj->company_name;
    $company_description = $obj->company_description;
    $full_name = $obj->full_name;
    $email_address = $obj->email_address;
    $mobile_phone = $obj->mobile_phone;
    $ratings1 = $obj->ratings1;
    $ratings2 = $obj->ratings2;
    $ratings3 = $obj->ratings3;
    $ratings4 = $obj->ratings4;
    $ratings5 = $obj->ratings5;
    $imageprof = $obj->image;
    //echo '<pre>';
    //var_dump($obj);
    //echo '</pre>';
endforeach;


//add to database bpccustomer, bpcbooking
if (isset ($_POST['bookphonecallsubmit']))
{

//    $contact1_name_1 = isset($_POST['contact1']) ? $_POST['contact1'] : '';
//    $contact2_name_1 = isset($_POST['contact2']) ? $_POST['contact2'] : '';
//    $contact1_1 = isset($_POST['contactname1']) ? $_POST['contactname1'] : '';
//    $contact2_1 = isset($_POST['contactname2']) ? $_POST['contactname2'] : '';

    if((!isset($_POST['contact2'])) || ($_POST['contact2'] == '') || ($_POST['contact2'] == 'Please Select...') || (!isset($_POST['contactname2'])) || ($_POST['contactname2'] == '') || ($_POST['contactname2'] == 0)) {
        $_POST['contact2'] = '';
        $_POST['contactname2'] = '';
    }

    $passwordtoken = bin2hex(openssl_random_pseudo_bytes(16));
    $title = $_POST['title'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $password = $passwordtoken;
    $fbemail = $_POST['fbemail'];
    $dateofbirth = $_POST['birthday'];
    $gender = $_POST['gender'];
    $contact1_name = $_POST['contact1'];
    $contact1 = $_POST['contactname1'];
    $contact2_name = $_POST['contact2'];
    $contact2 = $_POST['contactname2'];


    function bpcinsertcustomer( $title, $firstname, $lastname, $email, $password, $fbemail, $dateofbirth, $gender, $contact1_name, $contact1, $contact2_name, $contact2 )
    {
        global $wpdb;
        $table_name = $wpdb->prefix . 'bpccustomer';
        $wpdb->insert( $table_name, array(
            'title' => $title,
            'firstname' => $firstname,
            'lastname' => $lastname,
            'email' => $email,
            'password' => $password,
            'fbemail' => $fbemail,
            'dateofbirth' => $dateofbirth,
            'gender' => $gender,
            'contact1_name' => $contact1_name,
            'contact1' => $contact1,
            'contact2_name' => $contact2_name,
            'contact2' => $contact2
        ));
    }
    bpcinsertcustomer( $title, $firstname, $lastname, $email, $password, $fbemail, $dateofbirth, $gender, $contact1_name, $contact1, $contact2_name, $contact2);


    global $wpdb;
    $table_name = $wpdb->prefix . 'bpccustomer';
    $myrows = $wpdb->get_results("SELECT bpccustomerid, email FROM ".$table_name." WHERE email = '$email' ORDER BY bpccustomerid DESC LIMIT 1");
    foreach ($myrows as $obj) :
        $bpccustomeridtoget = $obj->bpccustomerid;
    endforeach;


    if (isset($_POST["enquiry"])) {
        $answer = $_POST['enquiry'];
        if ($answer == "organisation") {
            $company_number = '';
            $company = '';
            $organisation_name = $_POST['organisationname'];
        } else {
            $company_number = $_POST['company_number'];
            $company = $_POST['company'];
            $organisation_name = '';
        }
    }


    $datetocallback = explode("/", $_POST['callbackdate']);
    $datetocallback = $datetocallback[2].'-'.$datetocallback[1].'-'.$datetocallback[0];
    $callbackdate = $datetocallback;
    $callbacktime = $_POST['time'];
    $partner_id = $partner_id;
    $enquirytype = $_POST['enquirytype'];
    $enquiry = $_POST['yourenquiry'];
    $status = 'pending';
    $bpccustomerid = $bpccustomeridtoget;


    function bpcinsertcbooking( $callbackdate, $callbacktime, $partner_id, $enquirytype, $enquiry, $company_number, $company, $organisation_name, $status, $bpccustomerid )
    {
        global $wpdb;
        $table_name = $wpdb->prefix . 'bpcbooking';
        $wpdb->insert( $table_name, array(
            'callbackdate' => $callbackdate,
            'callbacktime' => $callbacktime,
            'partnersid' => $partner_id,
            'enquirytype' => $enquirytype,
            'enquiry' => $enquiry,
            'company_number' => $company_number,
            'company' => $company,
            'organisation_name' => $organisation_name,
            'status' => $status,
            'bpccustomerid' => $bpccustomerid
        ));
    }
    bpcinsertcbooking( $callbackdate, $callbacktime, $partner_id, $enquirytype, $enquiry, $company_number, $company, $organisation_name, $status, $bpccustomerid );


    //start for Testing site
    $mobile_number = '';
    $home_phone = '';
    $office_phone = '';
    if($contact1_name == 'Mobile Phone') {
        $mobile_number = $contact1;
    } else if($contact1_name == 'Home Phone') {
        $home_phone = $contact1;
    } else if($contact1_name == 'Office Phone') {
        $office_phone = $contact1;
    }
    
    if($contact2_name == 'Mobile Phone') {
        $mobile_number = $contact2;
    } else if($contact2_name == 'Home Phone') {
        $home_phone = $contact2;
    } else if($contact2_name == 'Office Phone') {
        $office_phone = $contact2;
    }

    $now = new DateTime();
    $currentdatetime = $now->format('Y-m-d H:i:s');

    $testing_db = new wpdb('dbo639369002','1qazxsw2!QAZXSW@','db639369002','db639369002.db.1and1.com');

    $table_name = 'wp_enquiry_user';
    $testing_db->insert( $table_name, array(
        'title' => $title,
        'first_name' => $firstname,
        'last_name' => $lastname,
        'mobile_number' => $mobile_number,
        'home_phone' => $home_phone,
        'office_phone' => $office_phone,
        'email_address' => $email,
        'facebook_email' => $fbemail,
        'website' => '',
        'company' => $company,
        'company_number' => $company_number,
        'created_at' => $currentdatetime,
        'updated_at' => ''
    ));


    $rows = $testing_db->get_results("SELECT * FROM wp_enquiry_user WHERE email_address = '$email' ORDER BY id DESC LIMIT 1");
    foreach ($rows as $obj) :
        $user_id = $obj->id;
    endforeach;


    $table_name_ = 'wp_enquiry';
    $testing_db->insert( $table_name_, array(
        'partner_id' => $partner_id,
        'status' => $enquirytype,
        'category' => '',
        'contact_enquiry' => $enquiry,
        'partner_notes' => '',
        'callback_date' => $callbackdate,
        'callback_time' => $callbacktime,
        'user_id' => $user_id,
        'user_email' => $email,
        'bpc_user_id' => $bpccustomerid,
        'livechat_user_id' => '',
        'mach_user_id' => '',
        'created_at' => $currentdatetime,
        'updated_at' => ''
    ));
    //end for Testing site


    $url = home_url('/thank-you/');
    redirect($url);
}

function redirect($url){
    $string = '<script type="text/javascript">';
    $string .= 'window.location = "' . $url . '"';
    $string .= '</script>';
    echo $string;
}