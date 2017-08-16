<script>
jQuery(document).ready(function(){

 	jQuery('input:radio[name=time]').click(function(){ 		
 		if ( $("#callbackdate").val().length > 0 ) {
 			document.getElementById('datepicked').innerHTML = $datenow;
 			document.getElementById('timeselected').innerHTML = ($("input[name=time]:checked").val());
 			jQuery('.home-step-2').delay(500).slideDown(500);
			jQuery('.home-step-1').delay(500).slideUp(500);
			jQuery('.home-step-3').delay(500).slideUp(500);
			jQuery('.home-step-4').delay(500).slideUp(500);
 		}		
	});

	function timeFunction()
	{ 
		if ( $("#callbackdate").val().length > 0 ) {
		 	document.getElementById('datepicked').innerHTML = $datenow;
		 	document.getElementById('timeselected').innerHTML = ($("input[name=time]:checked").val());
		 	jQuery('.home-step-2').delay(500).slideDown(500);
			jQuery('.home-step-1').delay(500).slideUp(500);
			jQuery('.home-step-3').delay(500).slideUp(500);
			jQuery('.home-step-4').delay(500).slideUp(500);
 		}	
	}

	/*jQuery('.proceed-btn-1').click(function(){
		jQuery('.home-step-2').delay(500).slideDown(500);
		jQuery('.home-step-1').delay(500).slideUp(500);
		jQuery('.home-step-3').delay(500).slideUp(500);
		jQuery('.home-step-4').delay(500).slideUp(500);
	});*/
	jQuery('.proceed-btn-2').click(function(){
		if ( $("#callbackdate").val().length > 0 ) {
			document.getElementById('datepicked2').innerHTML = $datenow;
			document.getElementById('timeselected2').innerHTML = ($("input[name=time]:checked").val());
			jQuery('.home-step-4').delay(500).slideDown(500);
			jQuery('.home-step-1').delay(500).slideUp(500);
			jQuery('.home-step-2').delay(500).slideUp(500);
			jQuery('.home-step-3').delay(500).slideUp(500);
		}
	});
	
	jQuery('.proceed-btn-3').click(function(){
		if ( $("#callbackdate").val().length > 0 ) {
			document.getElementById('datepicked1').innerHTML = $datenow;
			document.getElementById('timeselected1').innerHTML = ($("input[name=time]:checked").val());
			jQuery('.home-step-3').delay(500).slideDown(500);
			jQuery('.home-step-1').delay(500).slideUp(500);
			jQuery('.home-step-2').delay(500).slideUp(500);
			jQuery('.home-step-4').delay(500).slideUp(500);
		}
	});
	jQuery('#name_not_listed').click(function(){
		if ( $("#callbackdate").val().length > 0 ) {
			document.getElementById('datepicked1').innerHTML = $datenow;
			document.getElementById('timeselected1').innerHTML = ($("input[name=time]:checked").val());
			jQuery('.home-step-3').delay(500).slideDown(500);
			jQuery('.home-step-1').delay(500).slideUp(500);
			jQuery('.home-step-2').delay(500).slideUp(500);
			jQuery('.home-step-4').delay(500).slideUp(500);
		}
	});
	jQuery('.step-1-prev-btn').click(function(){
			jQuery('.home-step-1').delay(500).slideDown(500);
			jQuery('.home-step-2').delay(500).slideUp(500);
			jQuery('.home-step-3').delay(500).slideUp(500);
			jQuery('.home-step-4').delay(500).slideUp(500);
	});
	jQuery('.step-2-prev-btn').click(function(){
		jQuery('.home-step-2').delay(500).slideDown(500);
		jQuery('.home-step-1').delay(500).slideUp(500);
		jQuery('.home-step-3').delay(500).slideUp(500);
		jQuery('.home-step-4').delay(500).slideUp(500);
	});
	jQuery('.step-3-prev-btn').click(function(){
		jQuery('.home-step-3').delay(500).slideDown(500);
		jQuery('.home-step-1').delay(500).slideUp(500);
		jQuery('.home-step-2').delay(500).slideUp(500);
		jQuery('.home-step-4').delay(500).slideUp(500);
	});
});
  var $comp_name = document.getElementById('company_name').value;
  document.title = $comp_name + ' | BookPhoneCall.com';

</script>

<div id="footer">
  <div id="inner-wrapper e3ve-footer-inner">
    <div class="footer-nav">
      <ul>
        <li><a href="#">Home</a><div class="hover-arrow"></div></li>
        <li><a href="#">About Us</a><div class="hover-arrow"></div></li>
        <li><a href="#">Contact Us</a><div class="hover-arrow"></div></li>
        <li><a href="#">Terms &amp; Privacy</a><div class="hover-arrow"></div></li>
        <li><a href="#">Cookie Policy</a><div class="hover-arrow"></div></li>
        <li><a href="#">Register</a><div class="hover-arrow"></div></li>
        <li><a href="#">Login</a><div class="hover-arrow"></div></li>
      </ul>
      <div class="footer-social-icons">
        <ul class="social-icons">
            <li><a href="" class="social-icon"> <i class="fa fa-facebook"></i></a></li>
            <li><a href="" class="social-icon"> <i class="fa fa-twitter"></i></a></li>
            <li><a href="" class="social-icon"> <i class="fa fa-linkedin"></i></a></li>
        </ul>
    </div>
    </div>
    <div class="fbg">
    <div class="footer-app-img">
      <div class="apple-app-icon"><a href=""><img src="https://bookphonecall.com/wp-content/uploads/2017/01/appleapp.png" width="166" height="50"></a></div>
      <div class="android-app-icon"><a href=""><img src="https://bookphonecall.com/wp-content/uploads/2017/01/Android-app-store.png" width="143" height="50"></a></div>
    </div>
    <div class="footer-info">
      <p>&copy; 2017 All Rights Reserved, BookPhoneCall.com, Suite 11, Zeal House, 8 Deer Park Road, London, SW19 3UU. ICO Registration Number: ZA167803, Tel: 0203 0120 251 Fax: 0203 0120 254 Email: support@bookphonecall.com</p>
    </div>
    </div>
  </div>
</div>
</div>
<?php wp_footer(); ?>
</body></html>