
window.addEventListener('DOMContentLoaded', function() {
	var video = document.getElementById('sourcevid');

	if (navigator.getUserMedia) 
	{
		navigator.getUserMedia('video', successCallback, errorCallback);
		function successCallback(stream) {
			video.src = stream;
		}
		function errorCallback(error) {
			console.error('An error occurred: [CODE ' + error.code + ']');
			return;
		}
	} 
	else 
	{
		console.log('Native web camera streaming (getUserMedia) is not supported in this browser.');
		return;
	}
	
}, false);

$('#sourcevid').click(function(){
	decoder();
});

$('#start').click(function(){
	$('#description').css('display','none');
});


