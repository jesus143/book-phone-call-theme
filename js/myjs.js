//Calendar
 $directorList = '';

$(document).ready(function()
{




  $catch_partner_id = document.getElementById('partner_id_to_get').value;
  var dates_to_fetch = document.getElementById('datetofetch').value;
  console.log(dates_to_fetch);
  var availableDates = JSON.parse(dates_to_fetch);
  console.log(availableDates);
    function available(date) {
      dmy = date.getDate() + "-" + (date.getMonth()+1) + "-" + date.getFullYear();
      if ($.inArray(dmy, availableDates) != -1) {
        return [true, "","Available"];
      } else {
        return [false,"","unAvailable"];
      }
    }
  var dateToday = new Date();
console.log(dateToday);

  $( "#datepicker" ).datepicker({
    beforeShowDay: available,
    firstDay: 1,
    minDate: dateToday
  });


  $('#datepicker a.ui-state-active').removeClass('ui-state-active');
  $('#datepicker a.ui-state-hover').removeClass('ui-state-hover');

  date = new Date().format('d/m/Y');
  $.get( "https://bookphonecall.com/wp-content/plugins/bpc-partner-time/bpc-get-date.php?datenow="
  +date+"&partnerid="+$catch_partner_id, function( data ) {
    var isNoScheduleForTheDay = data.indexOf("No Schedule Display");
      // $("#datepicker").html("");
      if(isNoScheduleForTheDay > 0) {
        var dateToday = new Date();
        $( "#datepicker" ).datepicker({ 
            beforeShowDay: available, 
            minDate: 1, 
            firstDay: 1,
            minDate: dateToday,

      });
        $('#datepicker a.ui-state-active').removeClass('ui-state-active');
        $('#datepicker a.ui-state-hover').removeClass('ui-state-hover');
      }
    }); //end get

  document.getElementById('company_name_step3').innerHTML = document.getElementById('company_name').value;
  document.getElementById('company_name_step4').innerHTML = document.getElementById('company_name').value;

  $("#company").keyup(function(e) {
    var query = $(this).val(); 
    $("#company").autocomplete({
      source: "cha/company.php?query="+query,
      minLength: 2,
      open: function(event, ui) {
        var url = "<li id='nocompany'> Can't Find Your Company? <span id='gotoOrganisation' onclick=gotoOrganisationFunction() style='text-decoration:underline; color: #0000FF; cursor: pointer;'>click here ></a></li>";
        $("ul.ui-autocomplete.ui-menu").append(url);
      },
      select: function (event, ui) {
        $("#director_column_q, #name_container, #director_name_container").css('display', 'none');
        var company_number = (JSON.stringify(ui.item.company_number));
        var address_snippet = (JSON.stringify(ui.item.address_snippet));
        document.getElementById('company_number').value = company_number.replace(/\"/g, "");   
        address_snippet_split = address_snippet.replace(/,/g, '<br>'); 
        document.getElementById('address_snippet').innerHTML = '<strong>Address:</strong> <br>' + address_snippet_split.replace(/\"/g, "");
        document.getElementById('verify_company_container').style.display='block';  
        $('#director_name').val('');
        document.getElementById('director_yes').checked = false;
        document.getElementById('director_no').checked = false;
        document.getElementById('company_officers_name').innerHTML = '';
        var company_number_for_officer = document.getElementById('company_number').value;
        $.get('cha/companyofficers.php?term=' + company_number_for_officer, function(data){
          data = JSON.parse(data);
            $directorList = data;
            for (var i = 0; i < data.length; i++) {
              var  t =  data[i]['namesss'];
              var n = t.indexOf("'");
                function ucFirst(string) {
                    return string.substring(0, 1).toUpperCase() + string.substring(1).toLowerCase();
                }
              var capitalize_officers = ucFirst(data[i]['namesss']);
              var format_change_officers = capitalize_officers.split(',')[0];
              var format_change_officers_after = capitalize_officers.split(',')[1] + ' ' + capitalize_officers.split(',')[0];       
                if( n === -1) {
                  document.getElementById('company_officers_name').innerHTML += "<p style='cursor: pointer; text-transform: capitalize;' name='officersname' id='company_officers_name_radio' onclick=myFunction('"+i+"') /><img src='https://bookphonecall.com/wp-content/uploads/2016/12/ltd-company.png' width='15' />" + format_change_officers_after +  "</p>";
                  document.getElementById('company_officers_name').innerHTML += "<input type='hidden' style='text-transform: capitalize;' value='"+ format_change_officers_after + "' id='company_officers_name_text_"+i+"' />";     
                } else {
                  var strnameString = t.replace(/'/g, "&#8217;");
                  var capitalize_officers_converted_quote = ucFirst(strnameString);
                  var format_change_officers_converted_quote = capitalize_officers_converted_quote.split(',')[0];
                  var format_change_officers_after_converted_quote = capitalize_officers_converted_quote.split(',')[1] + ' ' + capitalize_officers_converted_quote.split(',')[0];
                  document.getElementById('company_officers_name').innerHTML += "<p style='cursor: pointer; text-transform: capitalize;' name='officersname' id='company_officers_name_radio' onclick=myFunction('"+i+"') /><img src='https://bookphonecall.com/wp-content/uploads/2016/12/ltd-company.png' width='15' />" + format_change_officers_after + "</p>";
                  document.getElementById('company_officers_name').innerHTML += "<input type='hidden' style='text-transform: capitalize;' value='"+ format_change_officers_after_converted_quote + "' id='company_officers_name_text_"+i+"' />";         
                }
            } // end for loop
        }); // end get
      }, // end select event
    }); // end autocomplete event
  }); // end keyup event

  // Submit button disabled
  $("#bookphonecallsubmit").attr("disabled","disabled");
  $("#agreement").click(function(){
    if (!$('#e3ve-title').val() ) {
      document.getElementById('consumer_title').innerHTML = 'Please choose Title';
      document.getElementById('e3ve-title').setAttribute("style", "border: 1px solid #ff0000;");
      document.getElementById('agreement').checked = false;
      $("#bookphonecallsubmit").attr("disabled","disabled"); 
    } else if (!$('#e3ve-first-name').val() ) {
      document.getElementById('consumer_title').innerHTML = 'Please enter your First Name';
      document.getElementById('e3ve-first-name').setAttribute("style", "border: 1px solid #ff0000;text-transform: capitalize;");
      document.getElementById('agreement').checked = false;
      $("#bookphonecallsubmit").attr("disabled","disabled"); 
    } else if (!$('#e3ve-last-name').val() ) {
      document.getElementById('consumer_title').innerHTML = 'Please enter your Last Name';
      document.getElementById('e3ve-last-name').setAttribute("style", "border: 1px solid #ff0000;text-transform: capitalize;");
      document.getElementById('agreement').checked = false;
      $("#bookphonecallsubmit").attr("disabled","disabled"); 
    } else if (!$('#e3ve-email').val() ) {
      document.getElementById('consumer_title').innerHTML = 'Please enter your Email Address';
      document.getElementById('e3ve-email').setAttribute("style", "border: 1px solid #ff0000;width: 70%;");
      document.getElementById('agreement').checked = false;
      $("#bookphonecallsubmit").attr("disabled","disabled"); 
    } else if (!$('#eve-contact1').val() ) {
      document.getElementById('consumer_title').innerHTML = 'Please select your contact number';
      document.getElementById('eve-contact1').setAttribute("style", "border: 1px solid #ff0000;");
      document.getElementById('agreement').checked = false;
      $("#bookphonecallsubmit").attr("disabled","disabled"); 
    } else if (!$('#contact11').val() ) {
      document.getElementById('consumer_title').innerHTML = 'Please enter your Contact Number';
      document.getElementById('contact11').setAttribute("style", "border: 1px solid #ff0000;margin-left: 10px;");
      document.getElementById('agreement').checked = false;
      $("#bookphonecallsubmit").attr("disabled","disabled"); 
    } else if (!$('#eve-enquirytype').val() ) {
      document.getElementById('consumer_title').innerHTML = 'Please enter your Enquiry Type';
      document.getElementById('eve-enquirytype').setAttribute("style", "border: 1px solid #ff0000;");
      document.getElementById('agreement').checked = false;
      $("#bookphonecallsubmit").attr("disabled","disabled"); 
    } else if (!$('#eve-yourenquiry').val() ) {
      document.getElementById('consumer_title').innerHTML = 'Please enter your enquiry message';
      document.getElementById('eve-yourenquiry').setAttribute("style", "border: 1px solid #ff0000; width: 100%; height: 100px;");
      document.getElementById('agreement').checked = false;
      $("#bookphonecallsubmit").attr("disabled","disabled"); 
    } else if ($("#agreement").is(":checked")) {
      document.getElementById('consumer_title').innerHTML = '';
      $("#bookphonecallsubmit").removeAttr("disabled");
    }  else {
      $("#bookphonecallsubmit").attr("disabled","disabled");
    }
  }); // end click event

  $("input[name='enquiry']").click(function() 
  {
    if($("#consumer").is(":checked")) { 
      document.getElementById('organisationname_column').style.display='none';
      document.getElementById('director_column').style.display='none'; 
      document.getElementById('director_column_q').style.display='none';
      document.getElementById('director_name_container').style.display='none'; 
      document.getElementById('name_container').style.display='none';
      document.getElementById('company_officers_name').style.display='none';
      document.getElementById('name_not_listed').style.display='none';
      document.getElementById('tablediv').style.display='none';  
      document.getElementById('tablediv2').style.display='none'; 
      document.getElementById('confirm_step2').style.display='none';
      //emptied field
      $('#company').val('');
      $('#address_snippet').empty();
      document.getElementById('verify_company_container').style.display='none';
      //document.getElementById('verifycompany').checked = false;
      document.getElementById('director_yes').checked = false;
      document.getElementById('director_no').checked = false;
      $('#director_name').val('');    
        setTimeout(function(){
          if ( $("#callbackdate").val().length > 0 ) {
            document.getElementById('datepicked1').innerHTML = $datenow;
            document.getElementById('timeselected1').innerHTML = ($("input[name=time]:checked").val());
            jQuery('.home-step-3').delay(500).slideDown(500);
            jQuery('.home-step-1').delay(500).slideUp(500);
            jQuery('.home-step-2').delay(500).slideUp(500);
            jQuery('.home-step-4').delay(500).slideUp(500);
          }
        }, 500);
    } else if($("#ltdcompany").is(":checked")) {
      document.getElementById('organisationname_column').style.display='none';
      document.getElementById('director_column').style.display='block';   
      document.getElementById('tablediv').style.display='block';  
      document.getElementById('tablediv2').style.display='block';  
      document.getElementById('confirm_step2').style.display='none';
        if($("#director_yes").is(":checked")){
          document.getElementById('director_name_container').style.display='block'; 
        }
    } else if($("#organisation").is(":checked")) {
      document.getElementById('organisationname_column').style.display='block';
      document.getElementById('director_column').style.display='none'; 
      document.getElementById('director_column_q').style.display='none';
      document.getElementById('director_name_container').style.display='none'; 
      document.getElementById('name_container').style.display='none';
      document.getElementById('company_officers_name').style.display='none';
      document.getElementById('name_not_listed').style.display='none';
      document.getElementById('tablediv').style.display='none';  
      document.getElementById('tablediv2').style.display='none';
      //emptied field
      $('#company').val('');
      $('#address_snippet').empty();
      document.getElementById('verify_company_container').style.display='none';
      // document.getElementById('verifycompany').checked = false;
      document.getElementById('director_yes').checked = false;
      document.getElementById('director_no').checked = false;
      $('#director_name').val(''); 
    }
  }); // end click event

  $("#verifycompany").click(function(){
    document.getElementById('director_column_q').style.display='block';
  });

  $("input[name='director']").click(function()
  {
    if($("#director_yes").is(":checked")) {
      $("#director_column_q").css('display', 'none');
      $("#director_name_container").css('margin-top', '12px');
      document.getElementById('director_name_container').style.display='block'; 
      document.getElementById('name_container').style.display='block';
      document.getElementById('company_officers_name').style.display='block';
      document.getElementById('name_not_listed').setAttribute("style", "display: block; cursor: pointer; border-top: 1px #7a7a7a solid; padding-top: 5px;");
    } else {
      document.getElementById('director_name_container').style.display='none'; 
      document.getElementById('name_container').style.display='none';
      document.getElementById('company_officers_name').style.display='none';
      document.getElementById('name_not_listed').style.display='none';
        setTimeout(function(){
          if ( $("#callbackdate").val().length > 0 ) {
            document.getElementById('datepicked1').innerHTML = $datenow;
            document.getElementById('timeselected1').innerHTML = ($("input[name=time]:checked").val());
            jQuery('.home-step-3').delay(500).slideDown(500);
            jQuery('.home-step-1').delay(500).slideUp(500);
            jQuery('.home-step-2').delay(500).slideUp(500);
            jQuery('.home-step-4').delay(500).slideUp(500);
          }
        }, 500);
    }
  }); // end click event 
}) //end of document ready

$(document).on("change", "#datepicker", function () {
  $catch_partner_id = document.getElementById('partner_id_to_get').value;
  $datenow = $.datepicker.formatDate("dd/mm/yy", $(this).datepicker("getDate"));
  document.getElementById('callbackdate').value = $datenow;
  document.getElementById('home-arrow-1').innerHTML = '<img src="https://bookphonecall.com/wp-content/themes/BookPhoneCall/images/home-arrow.png" alt="" width="" height="">';
  $.get( "/wp-content/plugins/bpc-partner-time/bpc-get-date.php?datenow="+$datenow+"&partnerid="+$catch_partner_id, function( data ) {
    $( "#bpc-select-date-response" ).html(data);
  }); // end get
}); // end on change event 

function showConfirmbutton() {
  document.getElementById('confirm_step2').style.display='block';
}

function myFunction(id)
{
  var fname = '';
  var lname = '';
  var dname = $("#company_officers_name_text_"+id).val();
  $('#director_name').val(dname);
  setTimeout(function(){
    if ( $("#callbackdate").val().length > 0 ) {
      document.getElementById('datepicked1').innerHTML = $datenow;
      document.getElementById('timeselected1').innerHTML = ($("input[name=time]:checked").val());
      jQuery('.home-step-3').delay(500).slideDown(500);
      jQuery('.home-step-1').delay(500).slideUp(500);
      jQuery('.home-step-2').delay(500).slideUp(500);
      jQuery('.home-step-4').delay(500).slideUp(500);
    }
  }, 500);
  // get lastname
  directorSelectedFullName = $directorList[id]['namesss'];
  lname =  directorSelectedFullName.split(',')[0];
  lname = lname.substring(0, 1).toUpperCase() + lname.substring(1).toLowerCase();
  // get first name
  fname =  directorSelectedFullName.split(',')[1];
  fname = fname.split(' ');
  if(fname.length > 1) {
     fname = fname[1];
  }
  // add value to step 4 first name and lastname
  $("#e3ve-last-name").val(lname);
  $("#e3ve-first-name").val(fname);
} //end myFunction

function gotoOrganisationFunction()
{ 
  document.getElementById('organisation').checked = true;
  document.getElementById('organisationname_column').style.display='block';
  document.getElementById('director_column').style.display='none'; 
  document.getElementById('director_column_q').style.display='none';
  document.getElementById('director_name_container').style.display='none'; 
  document.getElementById('name_container').style.display='none';
  document.getElementById('company_officers_name').style.display='none';
  document.getElementById('name_not_listed').style.display='none';
  document.getElementById('tablediv').style.display='none';  
  document.getElementById('tablediv2').style.display='none';
  //emptied field
  $('#company').val('');
  $('#address_snippet').empty();
  document.getElementById('verify_company_container').style.display='none';
  // document.getElementById('verifycompany').checked = false;
  document.getElementById('director_yes').checked = false;
  document.getElementById('director_no').checked = false;
  $('#director_name').val(''); 
} // end gotoOrganisationFunction