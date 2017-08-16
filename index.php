<?php get_header(); ?>
<?php   date_default_timezone_set("Europe/London"); ?>
<div id="home-content">
<form action="" method="post">
  <div id="inner-wrapper">
    <div id="home-content-inner" class="home-step-1">
      <h2 align="center">Requesting a Call Back from...</h2>
      <div id="home-intro">
        <?php $businessProfile = get_option('of_businessProfile') ?>
        <?php query_posts('category_name='.$businessProfile.'&posts_per_page=1'); ?>
        <?php while (have_posts()) : the_post(); ?>
          <div class="home-table-image">
            <img src="<?php echo $imageprof; ?>">
          </div>
          <div class="home-table-description">
            <div class="home-table-business-name">
              <h2>
                <?php echo $company_name; ?>
                <input type="hidden" name="company_name" id="company_name" value="<?php echo $company_name; ?>">
                <input type="hidden" name="partner_id_to_get" id="partner_id_to_get" value="<?php echo $partner_id; ?>">
              </h2>
            </div>
            <div class="home-table-business-info">
              <?php echo $company_description; ?>
            </div>
          </div>
        <?php endwhile;?>
        <div class="home-table-checkbox">
          <ul class="ht-checkbox">
          <?php 
            echo ($ratings1 <> '' ? '<li>'.$ratings1.'</li>' : '');
            echo ($ratings2 <> '' ? '<li>'.$ratings2.'</li>' : '');
            echo ($ratings3 <> '' ? '<li>'.$ratings3.'</li>' : '');
            echo ($ratings4 <> '' ? '<li>'.$ratings4.'</li>' : '');
            echo ($ratings5 <> '' ? '<li>'.$ratings5.'</li>' : '');
           ?>
          </ul>
        </div>
      </div>
      <div id="home-date">

        <h3>Choose Date</h3>

        <?php
          require_once($_SERVER['DOCUMENT_ROOT'] .  "/wp-load.php");
          require_once($_SERVER['DOCUMENT_ROOT'] .  "/wp-content/plugins/bpc-partner-time/includes/bpc_partner_time_helper.php");
          require_once($_SERVER['DOCUMENT_ROOT'] .  "/wp-content/plugins/bpc-partner-time/helper.php");
          $version = 2;
          require_once("includes/Schedule.php");
          $date = array();
          $partner_id = $_GET['business'];
          $dateatthemo = date('H:i');
          use App\Schedule;


          /**
           * Execute version 2
           */
          if($version == 2)
          {
            $newcon         = new wpdb('dbo639369002', '1qazxsw2!QAZXSW@', 'db639369002', 'db639369002.db.1and1.com');
            $resultCustom   = $newcon->get_results("SELECT * FROM wp_bpc_appointment_settings WHERE partner_id = $partner_id", ARRAY_A);
            $resultStandard = $newcon->get_results("SELECT * FROM wp_bpc_appointment_setting_standard WHERE partner_id = $partner_id", ARRAY_A);
            $schedule       = new Schedule($resultStandard, $resultCustom, $partner_id, $newcon);
            echo '<input type="hidden" id="datetofetch" name="datetofetch" value=' . $schedule->getFinalDatesFlattenToJson() . ' />';
          }
          elseif ($version==1)
          {
            /**
             * Execute version 1
             */
            $newcon = new wpdb('dbo639369002','1qazxsw2!QAZXSW@','db639369002','db639369002.db.1and1.com');
            $rows = $newcon->get_results("SELECT * FROM wp_bpc_appointment_settings WHERE partner_id = $partner_id && close = 'no'");
            foreach ($rows as $obj) :
              if((strtotime($dateatthemo) < strtotime($obj->open_to)) and (strtotime($obj->date) == strtotime(date("Y-m-d"))) or (strtotime($obj->date) > strtotime(date("Y-m-d")))) {
                $originalDate = $obj->date;
                $newDate = date("Y-n-j", strtotime($originalDate));
                $newDate1 = explode("-", $newDate);
                $newDate2 = $newDate1[2].'-'.$newDate1[1].'-'.$newDate1[0];
                $date[] = $newDate2;
              }
            endforeach;
            $datetofetch = json_encode($date);
            echo '<input type="hidden" id="datetofetch" name="datetofetch" value='.$datetofetch.' />';
          }

        ?>        
        <div id="datepicker"></div>
        <p style="display: none;">Date Choosen: <input type="text" name="callbackdate" id="callbackdate"></p>
      </div>
      <div id="home-arrow-1"><img src="https://bookphonecall.com/wp-content/uploads/2017/01/to-left-arrow.png" alt="" style="    width: 55%;"></div>
      <div id="home-time">
        <?php  echo do_shortcode('[BPC_Partner_Time_Schedule]'); ?>
        <?php echo get_option('of_step1right') ?>
      </div>
      <!-- <div class="proceed-btn-1">Confirm Time & Date</div>-->
    </div>
    <div id="home-content-inner" class="home-step-2">
      <div class="prev-steps-wrapper">
        <div class="step-1-prev-btn"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/prev-btn-green-tick.png" width="21" height="21"> Step 1: Choose Time & Date (<span id="timeselected"></span> on <span id="datepicked"></span>)</div>
      </div>
      <div class="home-step-3-heading">
        <h2><?php echo get_option('of_step2heading') ?></h2>
      </div>
      <div class="home-step-3-content-container"> <?php echo get_option('of_step3content') ?>
        <div class="proceed-btn-3" id="confirm_step2" style="display: none;">Confirm Enquiry Type > </div>
      </div>
    </div>
    <div id="home-content-inner" class="home-step-3">
      <div class="prev-steps-wrapper">
        <div class="step-1-prev-btn"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/prev-btn-green-tick.png" width="21" height="21"> Step 1: Choose Time & Date (<span id="timeselected1"></span> on <span id="datepicked1"></span>)</div>
        <div class="step-2-prev-btn"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/prev-btn-green-tick.png" width="21" height="21"> STEP 2: ENQUIRY TYPE</div>
      </div>
      <div class="home-step-2-heading">
        <h2><?php echo get_option('of_step3heading') ?></h2>
      </div>
      <div class="step-2-content-container">
        <div class="home-first-request"> <?php echo get_option('of_step2left') ?>
          <div class="fr-btns">
            <div class="fr-continue-fb-btn">
              <?php do_shortcode('[bpc_fb_l_facebook_ui]'); ?>
              <!-- <fb:login-button autologoutlink="true" size="large" scope="public_profile,email,user_birthday" onlogin="checkLoginState();">-->
              <!-- </fb:login-button>-->
              <!--<img src="https://www.caterkart.com/images/login-facebook.png" onclick="FB.login()" />-->
              <div id="fb-status" style="display: none;"></div>
            </div>
            <div class="fr-continue-btn"> <a href="<?php echo get_option('of_continuebtn') ?>" class="proceed-btn-2" id="proceed-btn-2" >Continue >> </a> </div>
          </div>
        </div>
        <div class="home-step-2-or">
          <h4>OR</h4>
        </div>
        <div class="home-step-2-login">
          <div class="home-step-2-login-inner"> <?php echo get_option('of_step2right') ?> </div>
          <?php wp_login_form(); ?>
        </div>
      </div>
    </div>
    <div id="home-content-inner" class="home-step-4">
      <div class="prev-steps-wrapper">
        <div class="step-1-prev-btn"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/prev-btn-green-tick.png" width="21" height="21"> Step 1: Choose Time & Date (<span id="timeselected2"></span> on <span id="datepicked2"></span>)</div>
        <div class="step-2-prev-btn"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/prev-btn-green-tick.png" width="21" height="21"> STEP 2: ENQUIRY TYPE</div>
        <div class="step-3-prev-btn"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/prev-btn-green-tick.png" width="21" height="21"> STEP 3: CHOOSE METHOD (LOGGED INTO BOOKPHONECALL>COM ACCOUNT)</div>
      </div>
      <div class="home-step-4-heading">
        <h2><?php echo get_option('of_step4heading') ?></h2>
      </div>
      <div class="home-step-4-content-container">
        <div class="ca-fields-container">
          <ul class="ca-fields-inner-left">
            <?php echo get_option('of_step4left') ?>
          </ul>
          <ul class="ca-fields-inner-right">
            <?php echo get_option('of_step4right') ?> 
          </ul>
        </div>
        <div class="bpc-agreement-input">
          <input name="agreement" value="agreement" type="checkbox" id="agreement"> <?php echo get_option('of_step4agreement') ?>
        </div>
        <!--<div class="bpc-agreement-label"><?php echo get_option('of_step4agreement') ?></div>-->
        <div class="bookphonecall-btn">
          <input class="bpc-btn" name="bookphonecallsubmit" id="bookphonecallsubmit" value="Book Phone Call Now" type="submit">
        </div>
      </div>
    </div>
  </div>
  </form>
</div>
<?php get_footer(); ?>