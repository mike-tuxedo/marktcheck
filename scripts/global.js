// AUTOCOMPLETE
function doAutocomplete(searchField) {
    if(searchField.length < 3) 
        $('#autocompleteBox').hide();
    else 
    {
        $.post("autocomplete.php", {queryString: searchField}, function(data){
           if(data.length > 0) 
           {
                $('#autocompleteBox').show();
                $('#autocompleteList').html(data);
            }
        });
    }
}

function selectValue(value) {
    $('#searchField').val(value);
    setTimeout("$('#autocompleteBox').hide();", 200);
}

$(document).ready(function() { 
	
	// IPHONE SEARCHFIELD
	if(navigator.userAgent.match(/iPhone/i))
		$('#autocompleteBox ').css("margin-top", "40px");
	
	// CHECKLOGINVALUES
	$('#loginForm').submit(function(){
		var nameFieldLength = $('#nickname').val().length;
		var passwordLength = $('#password').val().length;
		var name = $('#nickname').val();
		var nameRegEx = /^[a-zA-Z0-9.üäöß._-]*$/;

		if(nameFieldLength < 3 || !nameRegEx.test(name))
		{
			$('#nickname').css('background', '#f33');
			$('p#missingFieldMsg').text('Name muss min 3 Zeichen lang sein');
			return false;
		}
		else if(passwordLength < 3)
		{
			$('#password').css('background', '#f33');
			$('#missingFieldMsg').text('Passwort muss min 3 Zeichen lang sein');
			return false;
		}
	});

	$('input').click(function(){
		$(this).css('background', 'white');
	});
	
	// CHECKSIGNUPVALUES
	$('#signUp').submit(function(){

		var nameFieldLength = $('#nickname').val().length;
		var passwordLength = $('#password').val().length;
		var email = $('#email').val();
		var name = $('#nickname').val();
		var emailRegEx = /^[a-zA-Z0-9.ü._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
		var nameRegEx = /^[a-zA-Z0-9.üäöß._-]*$/;

		if(nameFieldLength < 3 || !nameRegEx.test(name))
		{
			$('#nickname').css('background', '#f33');
			$('p#missingFieldMsg').text('Name muss min 3 Zeichen lang sein');
			return false;
		}
		else if(!emailRegEx.test(email))
		{
			$('#email').css('background', '#f33');
			$('#missingFieldMsg').text('die Emailadresse ist ungültig');
			return false;
		}
		else if(passwordLength < 3)
		{
			$('#password').css('background', '#f33');
			$('#missingFieldMsg').text('Passwort muss min 3 Zeichen lang sein');
			return false;
		}
	});

	$('input').click(function(){
		$(this).css('background', 'white');
	});
	
	// PRODUCTDETAILOPTION
    $('#productDetailNavigation a').live( 'click' , function () {

        $(this).next().slideToggle('slow', function(){

            $(this).prev().text(function(){
                if ($(this).next().is(":visible")) 
                {
                    $(this).css("background-image", "url(images/productDetailNavigationBackgroundClose.png), url(images/productDetailNavigationBackground.png)"); 
                }    
                else 
                { 
                    $(this).css("background-image", "url(images/productDetailNavigationBackgroundOpen.png), url(images/productDetailNavigationBackground.png)");
                }    
            });  
        
        });
        
        return false;
    
    }).next().hide(); 
	
	// SETTINGSEFFECT
    $("#settings").hide();

    $(".showSettings").click(function() {
        var opacity = $("#contentArea").css('opacity');
        if(opacity == 1) {
            $("#settings").css("margin-bottom", 130 + "px");
            $("#contentArea").fadeTo("slow", 0.2);

            $("#contentArea a").css("cursor", "default");

            // disable click on links  
            $("#contentArea a").bind('click', function(){ 
                return false; 
            });
        }    
        else {
        		$("#settings").css("margin-bottom", null);
            $("#contentArea").fadeTo("slow", 1);

            $("#contentArea a").css("cursor", "auto");

            // enable click on links
            $("#contentArea a").unbind();
        }    

        $("#settings").slideToggle(300);
        
    });    

    $('#contentArea').click(function() {
        var opacity = $("#contentArea").css('opacity');
        if(opacity < 0.3) {
            $("#contentArea").fadeTo("slow", 1);
            $("#settings").slideToggle(300);
            $("#contentArea a").unbind();
        }   
    });
	
	
	// show all results in categorylist
	var cntResults = 0;
	$('.searchResultListNavigation').each(function(){
		cntResults++;
		if(cntResults > 10)
			$(this).hide();
	});	
	
	$("#showMoreResults").click(function() {
		  $('.searchResultListNavigation').show();
		  $('.searchResultListNavigationLast').hide();
	});
	
	var yValue = 1000;

    $("img, a").mouseup(function(){
        $(this).css("opacity", "1");
    }).mousedown(function(){
        $(this).css("opacity", "0.5");
    });

    $('#productDetailNavigation').click(function(){
    	setTimeout(function() {window.scrollTo(0,2000);},400);
    });

	//show and hide Login or Logoutoption
    var session = "<?php echo $_SESSION['USER']; ?>";

    if(session == "")
    {
        $('#loginEntrie').hide();
        $('#logoutEntrie').show();
    }
    else
    {
        $('#logoutEntrie').hide();
        $('#loginEntrie').show();
    }
    
});
