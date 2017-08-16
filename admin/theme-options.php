<?php
add_action('init','of_options');
if (!function_exists('of_options')) {
function of_options(){

// VARIABLES
$themename = get_theme_data(STYLESHEETPATH . '/style.css');
$themename = $themename['Name'];
$shortname = "of";

// Populate OptionsFramework option in array for use in theme
global $of_options;
$of_options = get_option('of_options');
$GLOBALS['template_path'] = OF_DIRECTORY;

//Access the WordPress Categories via an Array
$of_categories = array();  
$of_categories_obj = get_categories('hide_empty=0');
foreach ($of_categories_obj as $of_cat) {
    $of_categories[$of_cat->cat_ID] = $of_cat->cat_name;}
$categories_tmp = array_unshift($of_categories, "Select a category:");    

//Access the WordPress Pages via an Array
$of_pages = array();
$of_pages_obj = get_pages('sort_column=post_parent,menu_order');    
foreach ($of_pages_obj as $of_page) {
    $of_pages[$of_page->ID] = $of_page->post_name; }
$of_pages_tmp = array_unshift($of_pages, "Select a page:");       

// Image Links to Options
$options_image_link_to = array("image" => "The Image","post" => "The Post"); 

//Testing 
$options_select = array("one","two","three","four","five"); 
$options_radio = array("one" => "One","two" => "Two","three" => "Three","four" => "Four","five" => "Five"); 
$align_option = array("left" => "Left", "center" => "Center", "right" => "Right"); 
$contact_option = array("no" => "Show no cotact in sidebar", "one" => "Show one contact in sidebar", "two" => "Show two contacts in sidebar"); 

//Stylesheets Reader
$alt_stylesheet_path = OF_FILEPATH . '/styles/';
$alt_stylesheets = array();
if ( is_dir($alt_stylesheet_path) ) {
    if ($alt_stylesheet_dir = opendir($alt_stylesheet_path) ) { 
        while ( ($alt_stylesheet_file = readdir($alt_stylesheet_dir)) !== false ) {
            if(stristr($alt_stylesheet_file, ".css") !== false) {
                $alt_stylesheets[] = $alt_stylesheet_file;
            }
        }    
    }
}

//More Options
$uploads_arr = wp_upload_dir();
$all_uploads_path = $uploads_arr['path'];
$all_uploads = get_option('of_uploads');
$other_entries = array("Select a number:","1","2","3","4","5","6","7","8","9","10","11","12","13","14","15","16","17","18","19");
$body_repeat = array("no-repeat","repeat-x","repeat-y","repeat");
$body_pos = array("top left","top center","top right","center left","center center","center right","bottom left","bottom center","bottom right");

// Set the Options Array
$options = array();

/********** 
Begin Adding options here ( IMPORTANT: Add your 1st heading before you add any options )***/

//General Heading
$options[] = array( "name" => "General Options",
          "type" => "heading");

//Favicon
$options[] = array( "name" => "Upload Custom Favicon",
          "desc" => "Upload a 16px x 16px Png/Gif image that will represent your website's favicon.",
          "id" => $shortname."_custom_favicon",
          "std" => "",
          "type" => "upload"); 
          $url =  OF_DIRECTORY . '/admin/images/'; 
          
//Google Analytics
$options[] = array( "name" => "Google Analytics Tracking Code",
          "desc" => "Paste your Google Analytics (or other) tracking code here. This will be added into the footer template of your theme.",
          "id" => $shortname."_google_analytics",
          "std" => "",
          "type" => "textarea"); 
          
          
//Header Options
$options[] = array( "name" => "Header Options",
          "type" => "heading"); 
          
//Banner Uploader
$options[] = array( "name" => "Banner Upload",
          "desc" => "Upload a 750x100 pixel image file, or specify the address of your online file. (http://yoursite.com/logo.png)",
          "id" => $shortname."_header-banner",
          "std" => "",
          "type" => "upload");
          $url =  OF_DIRECTORY . '/admin/images/';
          
//Banner Alternate Text
$options[] = array( "name" => "Banner Alternate Text",
          "desc" => "Enter text into the field",
          "id" => $shortname."_header-banner-alt",
          "std" => "Header Banner",
          "type" => "text"); 
          
//Step 1 Options
$options[] = array( "name" => "Step 1 Options",
          "type" => "heading");
          
          
//Business Profile
$options[] = array( "name" => "Business Profile",
          "desc" => "Hit the dropdown and select a category from the listings",
          "id" => $shortname."_businessProfile",
          "std" => "Select a category:",
          "type" => "select",
          "options" => $of_categories);
          
//Business Profile Form
$options[] = array( "name" => "Business Profile Form",
          "desc" => "Enter text or html into the field",
          "id" => $shortname."_businessprofileform",
          "std" => "Business form here..",
          "type" => "textarea");
          
//Left Side Content
$options[] = array( "name" => "Left Side Content",
          "desc" => "Enter text or html into the field",
          "id" => $shortname."_step1left",
          "std" => "Calendar Here",
          "type" => "textarea");
          
//Right Side Content
$options[] = array( "name" => "Right Side Content",
          "desc" => "Enter text or html into the field",
          "id" => $shortname."_step1right",
          "std" => "Time Here",
          "type" => "textarea"); 
          
//Step 2 Options
$options[] = array( "name" => "Step 2 Options",
          "type" => "heading");
          
//Heading Text
$options[] = array( "name" => "Heading Text",
          "desc" => "Enter text into the field",
          "id" => $shortname."_step2heading",
          "std" => "STEP 2: Choose Method",
          "type" => "text");
          
//Left Side Content
$options[] = array( "name" => "Left Side Content",
          "desc" => "Enter text or html into the field",
          "id" => $shortname."_step2left",
          "std" => "First Request Form Here...",
          "type" => "textarea"); 
          
//Facebook Button URL
$options[] = array( "name" => "Facebook Button URL",
          "desc" => "Enter url into the field",
          "id" => $shortname."_fbbtnurl",
          "std" => "#",
          "type" => "text"); 
          
//Continue Button URL
$options[] = array( "name" => "Continue Button URL",
          "desc" => "Enter url into the field",
          "id" => $shortname."_continuebtn",
          "std" => "#",
          "type" => "text");    
          
//Right Side Content
$options[] = array( "name" => "Right Side Content",
          "desc" => "Enter text or html into the field",
          "id" => $shortname."_step2right",
          "std" => "Login Form Here...",
          "type" => "textarea");
          
//Step 3 Options
$options[] = array( "name" => "Step 3 Options",
          "type" => "heading");
          
//Heading Text
$options[] = array( "name" => "Heading Text",
          "desc" => "Enter text into the field",
          "id" => $shortname."_step3heading",
          "std" => "STEP 3: Enquiry Type",
          "type" => "text");
          
//Step 3 Content
$options[] = array( "name" => "Step 3 Content",
          "desc" => "Enter text or html into the field",
          "id" => $shortname."_step3content",
          "std" => "Step 3 Content Here...",
          "type" => "textarea"); 
          
//Step 4 Options
$options[] = array( "name" => "Step 4 Options",
          "type" => "heading");
          
//Heading Text
$options[] = array( "name" => "Heading Text",
          "desc" => "Enter text into the field",
          "id" => $shortname."_step4heading",
          "std" => "STEP 4: Confirm Appointment",
          "type" => "text"); 
          
//Left Side Content
$options[] = array( "name" => "Left Side Content",
          "desc" => "Enter text or html into the field",
          "id" => $shortname."_step4left",
          "std" => "Consumer contents here..",
          "type" => "textarea");  
          
//Right Side Content
$options[] = array( "name" => "Right Side Content",
          "desc" => "Enter text or html into the field",
          "id" => $shortname."_step4right",
          "std" => "Call Back Number contents here..",
          "type" => "textarea"); 
          
//Agreement Text
$options[] = array( "name" => "Agreement Text",
          "desc" => "Enter text into the field",
          "id" => $shortname."_step4agreement",
          "std" => "I have read &amp; agree to the Terms &amp; Conditions and Privacy Policy",
          "type" => "text");                    
          
//Footer Options
$options[] = array( "name" => "Footer Options",
          "type" => "heading");
          
//Footer Copyright
$options[] = array( "name" => "Footer Copyright",
          "desc" => "Enter text into the field",
          "id" => $shortname."_footer-text",
          "std" => "© 2016 BookPhoneCall.com. All rights reserved.",
          "type" => "text");                 

/*** Stop adding options ***/

update_option('of_template',$options);            
update_option('of_themename',$themename);   
update_option('of_shortname',$shortname);
}
}
?>