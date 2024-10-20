/*
	this js assistant for check data valid and auto resize meta tab
	*/
jQuery(document).ready(function($) {
	$('.copy').on('click', function() {
		// Get the text content from the clicked element
		const textToCopy = $(this).text();

		// Create a temporary input element to hold the text
		const tempInput = $('<input>');
		$('body').append(tempInput);
		tempInput.val(textToCopy).select();

		// Copy the text to clipboard
		document.execCommand('copy');

		// Remove the temporary input element
		tempInput.remove();

		// Optionally, show a message or indication that the text has been copied
		alert('Copied to clipboard: ' + textToCopy);
	});
  $('input[type="tel"]').attr('maxlength','10');
  $('input[type="tel"]').on('input', function() {
    this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1');
  });
});
	Assistant = function(Language){
		this.language = Language==undefined?"en":Language;
		this.errorMessText ={
			"en":{
				"requireText":"Require Data Fields :",
				"emailText":"Email not valid",
				"phoneText":"Number phone not valid"
			},
			"vi":
			{
				"requireText":"Bạn Phải Nhập Đầy Đủ Các Trường:",
				"emailText":"Email không đúng định dạng",
				"phoneText":"Số điện thoại không đúng"
			}};
		}

		

		Assistant.prototype.checkData = function(parent){
			var pContainer = $('#'+parent || $(parent));
			if(pContainer == undefined){
				console.log("CheckData Error: parent argument wrong.");
				return false;
			}
	// check required field
	var childInput = $('input[type=text][required]');
	var childInputNotRequired = $('input[type=text][required=false]');
	var inputArr = pContainer.find(childInput).not(pContainer.find(childInputNotRequired));
	var inputNotValid = [];
	for (var i = 0; i < inputArr.length; i++) {
		if($(inputArr[i]).val()=="")
			inputNotValid.push($(inputArr[i]));
	}
	var mes = "";
	if(inputNotValid.length > 0)
	{
		mes += this.getMessError("requireText");
		for (var i = 0; i < inputNotValid.length; i++) {
			var s =' \n - '+ ($(inputNotValid[i]).attr('placeholder')== undefined? $(inputNotValid[i]).attr('id'): $(inputNotValid[i]).attr('placeholder'))+".";
			mes = mes + s;
			console.log(s);
		}
		console.log(mes);
		alert(mes);
		return false;
	}
	
	// Check sequentially for email,phone
	childInput = $('input[type=text]');
	inputArr = pContainer.find(childInput);
	for (var i = 0; i < inputArr.length; i++) {
		if($(inputArr[i]).attr('id')=="phone" && $(inputArr[i]).val() != ""){
			var phone = $('#phone').val();
			if(!this.checkPhone(phone)){
				alert(this.getMessError("phoneText"));
				return false;
			}
		}
		if($(inputArr[i]).attr('id')=="email" && $(inputArr[i]).val() != ""){
			var email = $('#email').val();
			if(!this.checkEmail(email)){
				alert(this.getMessError("emailText"));
				return false;
			}
		}
	}
	
	
}

Assistant.prototype.getMessError = function(errorKey){
	
	if(this.language == "en")
		return this.errorMessText.en[errorKey];
	else
		return this.errorMessText.vi[errorKey];
}

Assistant.prototype.checkEmail = function(emailText){
	var pattern = new RegExp(/^[+a-zA-Z0-9._-]+@[+a-zA-Z0-9._-]+\.[a-zA-Z]{2,4}$/i);
	return pattern.test(emailText);
}


Assistant.prototype.checkPhone = function (phoneNumber){

   var phonePrefix = [
   "03","05","07","09","08","012","018","016","019"
   ]
   var found = false;
   for (var i = 0; i < phonePrefix.length && !found; i++) {
      if(phoneNumber.search(phonePrefix[i]) == 0){
         found = true;
         break;
      } 
   }
   if(!found) {
      // console.log("ko có số");
      return false;
   }
   // if(phoneNumber.search("09") != 0){
   //    if(phoneNumber.length != 11){
   //       return false;
   //       console.log("09");
   //    }
   // }
   if(phoneNumber.search("03") != 0 && phoneNumber.search("05") != 0 && phoneNumber.search("07") != 0 && phoneNumber.search("08") != 0 && phoneNumber.search("09") != 0){
      if(phoneNumber.length != 11){
         return false;
         // console.log("10 số");
      }
   }
   if(phoneNumber.search("03") == 0 || phoneNumber.search("05") == 0 || phoneNumber.search("07") == 0 || phoneNumber.search("08") == 0 || phoneNumber.search("09") == 0){
      if(phoneNumber.length != 10){
         // console.log("11 số");
         return false;
      }
   }
   return true;
}
window.emojiStrip=function(u){function D(E){if(F[E])return F[E].exports;var C=F[E]={i:E,l:!1,exports:{}};return u[E].call(C.exports,C,C.exports,D),C.l=!0,C.exports}var F={};return D.m=u,D.c=F,D.i=function(u){return u},D.d=function(u,F,E){D.o(u,F)||Object.defineProperty(u,F,{configurable:!1,enumerable:!0,get:E})},D.n=function(u){var F=u&&u.__esModule?function(){return u.default}:function(){return u};return D.d(F,"a",F),F},D.o=function(u,D){return Object.prototype.hasOwnProperty.call(u,D)},D.p="",D(D.s=1)}([function(u,D,F){"use strict";u.exports=function(){return/(?:[\u261D\u26F9\u270A-\u270D]|\uD83C[\uDF85\uDFC2-\uDFC4\uDFC7\uDFCA-\uDFCC]|\uD83D[\uDC42\uDC43\uDC46-\uDC50\uDC66-\uDC69\uDC6E\uDC70-\uDC78\uDC7C\uDC81-\uDC83\uDC85-\uDC87\uDCAA\uDD74\uDD75\uDD7A\uDD90\uDD95\uDD96\uDE45-\uDE47\uDE4B-\uDE4F\uDEA3\uDEB4-\uDEB6\uDEC0\uDECC]|\uD83E[\uDD18-\uDD1C\uDD1E\uDD1F\uDD26\uDD30-\uDD39\uDD3D\uDD3E\uDDD1-\uDDDD])(?:\uD83C[\uDFFB-\uDFFF])?|(?:[\u231A\u231B\u23E9-\u23EC\u23F0\u23F3\u25FD\u25FE\u2614\u2615\u2648-\u2653\u267F\u2693\u26A1\u26AA\u26AB\u26BD\u26BE\u26C4\u26C5\u26CE\u26D4\u26EA\u26F2\u26F3\u26F5\u26FA\u26FD\u2705\u270A\u270B\u2728\u274C\u274E\u2753-\u2755\u2757\u2795-\u2797\u27B0\u27BF\u2B1B\u2B1C\u2B50\u2B55]|\uD83C[\uDC04\uDCCF\uDD8E\uDD91-\uDD9A\uDDE6-\uDDFF\uDE01\uDE1A\uDE2F\uDE32-\uDE36\uDE38-\uDE3A\uDE50\uDE51\uDF00-\uDF20\uDF2D-\uDF35\uDF37-\uDF7C\uDF7E-\uDF93\uDFA0-\uDFCA\uDFCF-\uDFD3\uDFE0-\uDFF0\uDFF4\uDFF8-\uDFFF]|\uD83D[\uDC00-\uDC3E\uDC40\uDC42-\uDCFC\uDCFF-\uDD3D\uDD4B-\uDD4E\uDD50-\uDD67\uDD7A\uDD95\uDD96\uDDA4\uDDFB-\uDE4F\uDE80-\uDEC5\uDECC\uDED0-\uDED2\uDEEB\uDEEC\uDEF4-\uDEF8]|\uD83E[\uDD10-\uDD3A\uDD3C-\uDD3E\uDD40-\uDD45\uDD47-\uDD4C\uDD50-\uDD6B\uDD80-\uDD97\uDDC0\uDDD0-\uDDE6])|(?:[#\*0-9\xA9\xAE\u203C\u2049\u2122\u2139\u2194-\u2199\u21A9\u21AA\u231A\u231B\u2328\u23CF\u23E9-\u23F3\u23F8-\u23FA\u24C2\u25AA\u25AB\u25B6\u25C0\u25FB-\u25FE\u2600-\u2604\u260E\u2611\u2614\u2615\u2618\u261D\u2620\u2622\u2623\u2626\u262A\u262E\u262F\u2638-\u263A\u2640\u2642\u2648-\u2653\u2660\u2663\u2665\u2666\u2668\u267B\u267F\u2692-\u2697\u2699\u269B\u269C\u26A0\u26A1\u26AA\u26AB\u26B0\u26B1\u26BD\u26BE\u26C4\u26C5\u26C8\u26CE\u26CF\u26D1\u26D3\u26D4\u26E9\u26EA\u26F0-\u26F5\u26F7-\u26FA\u26FD\u2702\u2705\u2708-\u270D\u270F\u2712\u2714\u2716\u271D\u2721\u2728\u2733\u2734\u2744\u2747\u274C\u274E\u2753-\u2755\u2757\u2763\u2764\u2795-\u2797\u27A1\u27B0\u27BF\u2934\u2935\u2B05-\u2B07\u2B1B\u2B1C\u2B50\u2B55\u3030\u303D\u3297\u3299]|\uD83C[\uDC04\uDCCF\uDD70\uDD71\uDD7E\uDD7F\uDD8E\uDD91-\uDD9A\uDDE6-\uDDFF\uDE01\uDE02\uDE1A\uDE2F\uDE32-\uDE3A\uDE50\uDE51\uDF00-\uDF21\uDF24-\uDF93\uDF96\uDF97\uDF99-\uDF9B\uDF9E-\uDFF0\uDFF3-\uDFF5\uDFF7-\uDFFF]|\uD83D[\uDC00-\uDCFD\uDCFF-\uDD3D\uDD49-\uDD4E\uDD50-\uDD67\uDD6F\uDD70\uDD73-\uDD7A\uDD87\uDD8A-\uDD8D\uDD90\uDD95\uDD96\uDDA4\uDDA5\uDDA8\uDDB1\uDDB2\uDDBC\uDDC2-\uDDC4\uDDD1-\uDDD3\uDDDC-\uDDDE\uDDE1\uDDE3\uDDE8\uDDEF\uDDF3\uDDFA-\uDE4F\uDE80-\uDEC5\uDECB-\uDED2\uDEE0-\uDEE5\uDEE9\uDEEB\uDEEC\uDEF0\uDEF3-\uDEF8]|\uD83E[\uDD10-\uDD3A\uDD3C-\uDD3E\uDD40-\uDD45\uDD47-\uDD4C\uDD50-\uDD6B\uDD80-\uDD97\uDDC0\uDDD0-\uDDE6])\uFE0F/g}},function(u,D,F){function E(u){return u.replace(A,"")}var C=F(0),A=C();u.exports=E}]);