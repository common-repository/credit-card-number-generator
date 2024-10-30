// Function for reverse string	
function strrev(str) {

	if (!str) return '';

	var revstr='';

	for (i = str.length-1; i>=0; i--)
		revstr+=str.charAt(i)

	return revstr;
}

// Function to generate a completed credit card number based on prefix and length
// 'prefix' is the start of the CC number as a string, any number of digits.
// 'length' is the length of the CC number to generate. Typically 13 or 16
function completed_number(prefix, length) {

	var ccnumber = prefix;

	// Generate digits
	while ( ccnumber.length < (length - 1) ) {

		ccnumber += Math.floor(Math.random()*10);
	}

	// Reverse number and convert to int 
	var reversedCCnumberString = strrev( ccnumber );
	var reversedCCnumber = new Array();

    for ( var i=0; i < reversedCCnumberString.length; i++ ) {

        reversedCCnumber[i] = parseInt( reversedCCnumberString.charAt(i) );
    }

    // Calculate sum        
    var sum = 0;
    var pos = 0;

    while ( pos < length - 1 ) {

        odd = reversedCCnumber[ pos ] * 2;

        if ( odd > 9 ) {

            odd -= 9;
        }

        sum += odd;

        if ( pos != (length - 2) ) {

            sum += reversedCCnumber[ pos +1 ];
        }

        pos += 2;
	}

    // Calculate check digit
    var checkdigit = (( Math.floor(sum/10) + 1) * 10 - sum) % 10;
    ccnumber += checkdigit;

    return ccnumber;
}

// Function to get a credit card number based on prefix list and length
function credit_card_number(prefixList, length) {

    var randomArrayIndex = Math.floor(Math.random() * prefixList.length); 
    var ccnumber = prefixList[ randomArrayIndex ];

    return completed_number(ccnumber, length);
}

// Arrays for credit card prefixes

// (Visa, Visa Electron, Mastercard, American Express, Discover, Maestro, JCB, Diners International, Diners USA Canada)
var visaPrefixList = new Array("4539", "4556", "4916", "4532", "4929", "40240071", "4485", "4716", "4");
var visaElectronPrefixList = new Array("4026", "417500", "4508", "4844", "4913", "4917");
var mastercardPrefixList = new Array("51", "52", "53", "54", "55", "222100", "272099");
var amexPrefixList = new Array("34", "37");
var discoverPrefixList = new Array("6011");
var maestroPrefixList = new Array("5018", "5020", "5038", "5893", "6304", "6759", "6761", "6762", "6763", "0604");
var jcbPrefixList = new Array("3528", "3529", "3530", "3531", "3532", "3533", "3534", "3535", "3536", "3537", "3538", "3539", "3540", "3541", "3542", "3543", "3544", "3545", "3589");
var dinersInternationalPrefixList = new Array("36");
var dinersNorthAmericaPrefixList = new Array("54", "55");

// Function for getting card numbers for shortcode
function get_card_number_output_shortcode() {

	// Call Functions
    jQuery(".shortcode-wrapper .visa").text(credit_card_number(visaPrefixList, 16, 1));
    jQuery(".shortcode-wrapper .visae").text(credit_card_number(visaElectronPrefixList, 16, 1));
	jQuery(".shortcode-wrapper .mc").text(credit_card_number(mastercardPrefixList, 16, 1));
	jQuery(".shortcode-wrapper .amex").text(credit_card_number(amexPrefixList, 15, 1));
	jQuery(".shortcode-wrapper .disc").text(credit_card_number(discoverPrefixList, 16, 1));
	jQuery(".shortcode-wrapper .maes").text(credit_card_number(maestroPrefixList, 16, 1));
	jQuery(".shortcode-wrapper .jcb").text(credit_card_number(jcbPrefixList, 16, 1));
	jQuery(".shortcode-wrapper .dcin").text(credit_card_number(dinersInternationalPrefixList, 14, 1));
	jQuery(".shortcode-wrapper .dcus").text(credit_card_number(dinersNorthAmericaPrefixList, 16, 1));
}

// Function for getting card numbers for footer
function get_card_number_output_footer() {

	 // Call Functions
    jQuery(".ccng-content-wrapper .visa").text(credit_card_number(visaPrefixList, 16, 1));
    jQuery(".ccng-content-wrapper .visae").text(credit_card_number(visaElectronPrefixList, 16, 1));
	jQuery(".ccng-content-wrapper .mc").text(credit_card_number(mastercardPrefixList, 16, 1));
	jQuery(".ccng-content-wrapper .amex").text(credit_card_number(amexPrefixList, 15, 1));
	jQuery(".ccng-content-wrapper .disc").text(credit_card_number(discoverPrefixList, 16, 1));
	jQuery(".ccng-content-wrapper .maes").text(credit_card_number(maestroPrefixList, 16, 1));
	jQuery(".ccng-content-wrapper .jcb").text(credit_card_number(jcbPrefixList, 16, 1));
	jQuery(".ccng-content-wrapper .dcin").text(credit_card_number(dinersInternationalPrefixList, 14, 1));
	jQuery(".ccng-content-wrapper .dcus").text(credit_card_number(dinersNorthAmericaPrefixList, 16, 1));
}

// Function to calculate the Luhn checksum
function ccng_calculate(Luhn) {

	var sum = 0;
	for (i=0; i<Luhn.length; i++ ) {
		sum += parseInt(Luhn.substring(i,i+1));
	}

	var delta = new Array (0, 1, 2, 3, 4, -4, -3, -2, -1, 0);
	for (i=Luhn.length-1; i>=0; i-=2 ) {		
		var deltaIndex = parseInt(Luhn.substring(i, i + 1));
		var deltaValue = delta[deltaIndex];	
		sum += deltaValue;
	}	

	var mod10 = sum % 10;
	mod10 = 10 - mod10;	

	if (mod10 == 10) {		
		mod10 = 0;
	}

	return mod10;
}

// Function to validate a credit card number using Luhn algorithm
function ccng_validate(Luhn) {

	Luhn = Luhn.replace(/\s/g, '');			

	var LuhnDigit = parseInt(Luhn.substring(Luhn.length-1, Luhn.length));
	var LuhnLess = Luhn.substring(0,Luhn.length-1);

	if (ccng_calculate(LuhnLess) == parseInt(LuhnDigit)) {
		return true;
	}	

	return false;
}

//Function to get credit card type by number
function ccng_creditcard_type( cc_number ) {
 
  	var cc_type;
 
  	//JCB
  	jcb_regex = new RegExp('^(?:2131|1800|35)[0-9]{0,}$'); //2131, 1800, 35 (3528-3589)
  	// American Express
  	amex_regex = new RegExp('^3[47][0-9]{0,}$'); //34, 37
  	// Diners Club
  	diners_regex = new RegExp('^3(?:0[0-59]{1}|[689])[0-9]{0,}$'); //300-305, 309, 36, 38-39
  	// Visa
  	visa_regex = new RegExp('^4[0-9]{0,}$'); //4
  	// MasterCard
  	mastercard_regex = new RegExp('^(5[1-5][0-9]{14}|2(22[1-9][0-9]{12}|2[3-9][0-9]{13}|[3-6][0-9]{14}|7[0-1][0-9]{13}|720[0-9]{12}))$'); //2221-2720, 51-55
  	maestro_regex = new RegExp('^(5[06789]|6)[0-9]{0,}$'); //always growing in the range: 60-69, started with / not something else, but starting 5 must be encoded as mastercard anyway

  	//Discover
  	discover_regex = new RegExp('^(6011|65|64[4-9]|62212[6-9]|6221[3-9]|622[2-8]|6229[01]|62292[0-5])[0-9]{0,}$');
  	////6011, 622126-622925, 644-649, 65

  	// get rid of anything but numbers
  	cc_number = cc_number.replace(/\D/g, '');
 
  	// checks per each, as their could be multiple hits
  	//fix: ordering matter in detection, otherwise can give false results in rare cases
  	if (cc_number.match(jcb_regex)) {
    	cc_type = "jcb";
  	} else if (cc_number.match(amex_regex)) {
    	cc_type = "amex";
  	} else if (cc_number.match(diners_regex)) {
    	cc_type = "diners_club";
  	} else if (cc_number.match(visa_regex)) {
    	cc_type = "visa";
  	} else if (cc_number.match(mastercard_regex)) {
   		cc_type = "mastercard";
  	} else if (cc_number.match(discover_regex)) {
    	cc_type = "discover";
  	} else if (cc_number.match(maestro_regex)) {
    	//if (cc_number[0] == '5') { //started 5 must be mastercard
      	//	cc_type = "mastercard";
    	//} else {
      		cc_type = "maestro"; //maestro is all 60-69 which is not something else, thats why this condition in the end
    	//}
  	} else {
    	cc_type = "unknown";
  	}
 
  	return cc_type;
}

// Function to generate card numbers based on selected card type
function generateCardNumbers(wrapper, prefixList, length) {
    var selectedCardType = wrapper.find(".wli-cards option:selected").attr("value");
    if (!selectedCardType) {
        wrapper.find(".output-wrapper").html('<div class="footer-output card-warning">Select card type first</div>');
        wrapper.find(".btn-copy-footer").hide();
        return;
    }

    wrapper.find(".output-wrapper").html('<div class="footer-output"><div id="wli-output-footer" class="' + wrapper.attr("data-option-value") + '"></div></div>');
    wrapper.find(".btn-copy-footer").hide();

    var generatedNumber = credit_card_number(prefixList, length);
    wrapper.find("#wli-output-footer").text(generatedNumber);

    if (generatedNumber.length > 0) {
        wrapper.find(".btn-copy-footer").show();
    }
}


// Document Ready
jQuery(document).ready(function() {

    function updateCardContentWrapper(wrapper) {
        wrapper.find(".btn-copy-footer").hide();
        var optionValue = wrapper.find(".wli-cards option:selected").attr("value");
        if (optionValue) {
            wrapper.attr("data-option-value", optionValue);
        }
    }

    jQuery(".ccng-content-wrapper .wli-cards").change(function() {
        var wrapper = jQuery(this).closest(".ccng-content-wrapper");
        updateCardContentWrapper(wrapper);
    }).change();

    jQuery(document).on("click", ".ccng-content-wrapper .btn-generate", function() {
        var wrapper = jQuery(this).closest(".ccng-content-wrapper");
        generateCardNumbers(wrapper, visaPrefixList, 16);
    });

    jQuery(document).on("click", ".ccng-content-wrapper .btn-copy-footer", function() {
        var wrapper = jQuery(this).parents(".ccng-content-wrapper");
        var clipboardFooter = new ClipboardJS(".btn-copy-footer", {
            text: function() {
                return wrapper.find("#wli-output-footer").text();
            }
        });
        clipboardFooter.on("success", function(e) {
			showCopiedNotice(wrapper);
            return e.text;
        });
        clipboardFooter.onClick({ currentTarget: this });
		clipboardFooter.destroy()
    });

    // Function to validate credit card number
    jQuery(document).on("click", ".ccng-content-wrapper .btn-validate", function() {
        var ccnumber_wrap = jQuery(this).closest(".ccng-content-wrapper");
        var ccnumber = ccnumber_wrap.find(".ccng_card_number").val();
        ccnumber_wrap.find(".ccng-input-wrapper").attr("class", "ccng-input-wrapper icn");
        if (ccnumber) {
            var cctype = ccng_creditcard_type(ccnumber);
            if (ccng_validate(ccnumber) && cctype) {
                ccnumber_wrap.find(".ccng-input-wrapper").addClass("icn-" + cctype);
                ccnumber_wrap.find(".ccng_validate_message").removeClass("error").addClass("success");
                ccnumber_wrap.find(".ccng_validate_message").html("The number is valid!");
            } else {
                ccnumber_wrap.find(".ccng_validate_message").removeClass("success").addClass("error");
                ccnumber_wrap.find(".ccng_validate_message").html("The number is NOT valid!");
            }
        } else {
            ccnumber_wrap.find(".ccng_validate_message").removeClass("success").addClass("error");
            ccnumber_wrap.find(".ccng_validate_message").html("Please enter a number first.");
        }
    });
});

function showCopiedNotice(wrap) {
	var notice = jQuery('<div class="copied-notice">Copied</div>');
	wrap.find('.wli-tooltip').append(notice);
	setTimeout(function() {
		notice.fadeOut('slow', function() {
			notice.remove();
		});
	}, 2000);
}