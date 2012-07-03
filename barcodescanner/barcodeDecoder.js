var numbers = [];
var startPixels = [];
var barsCnt = 0;
var colorAverage = 150;

var barsPerSequence = 28;
    var UPC_SET = {
        "3211": '0',
        "2221": '1',
        "2122": '2',
        "1411": '3',
        "1132": '4',
        "1231": '5',
        "1114": '6',
        "1312": '7',
        "1213": '8',
        "3112": '9'
    }

	var beginPx = 0;
	var oneUnit;
	var pixCnt = 0;
	var stripesCnt = 0;

function decoder()
{
	$('div').html('Now your image is stored in a canvas, klick again to reactivate the Cam');
	var video = document.getElementById('sourcevid');
	var canvas = document.getElementById('myCanvas');
	var canvasContext = canvas.getContext('2d');
				
	$('#myCanvas').css('display','block');
	canvas.width = $('#sourcevid').width();
	canvas.height = $('#sourcevid').height();
			
	canvasContext.drawImage(video,0,0,$('#sourcevid').width(),$('#sourcevid').height());

	var ch = canvas.height;
	var cw = canvas.width;
	var chC = parseInt(ch/2);

	//get one row from the middle of the image
	var imgData = canvasContext.getImageData(0, chC, cw, 1);
	var imgBW = [];
	var endPx;
	var cnt = true;

	var sum = 0;
	for(var i=0; i < imgData.width; i += 4)
	{
          var avg = imgData.data[i]*0.3 + imgData.data[i + 1]*0.59 + imgData.data[i + 2]*0.11;
          imgData.data[i] = avg;
          imgData.data[i + 1] = avg;
          imgData.data[i + 2] = avg;
          sum += 4*avg;
	}

	colorAverage = parseInt(sum/imgData.width);
	console.log('Durchschnittlicher Grauwert' + colorAverage);

	//search the beginnstripe and set a startpixel for every 4 stripes
	for(var i=0; i < imgData.data.length; i += 4)
	{		
		if(imgData.data[i] < colorAverage && pixCnt == 0)
		{
			pixCnt++;
			stripesCnt++;
		}
		else if(imgData.data[i] < colorAverage && pixCnt > 0)
		{
			pixCnt++;
			if(imgData.data[i-4] >= colorAverage)
			{
			 	stripesCnt++;
			 	cnt = true;
			}
		}
		else if(imgData.data[i] >= colorAverage && pixCnt > 0)
		{
			pixCnt++;
			if(imgData.data[i-4] < colorAverage){
			 	stripesCnt++;
			 	cnt = true;
			}
		}
		
		if(stripesCnt == 4 && cnt && startPixels.length != 6)
		{
			cnt = false;
			stripesCnt = 0;
			startPixels[startPixels.length] = i/4;
		}
		else if(stripesCnt == 5 && cnt && startPixels.length == 6)
		{
			cnt = false;
			stripesCnt = 0;
			startPixels[startPixels.length] = i/4;
		}
	}
	
	oneUnit = parseInt((startPixels[1] - startPixels[0])/7);
	console.log('Ein Streifen hat eine Breite von ' + oneUnit + 'px');

	for(var i=0; i<6; i++)
		calculateStripes(startPixels[i], imgData, oneUnit, 1);
	for(var i=7; i<13; i++)
		calculateStripes(startPixels[i], imgData, oneUnit, 0);

	print();
}


function calculateStripes(startPixl, imgData, oneUnit, startColor)
{
	var stripesColorIndex = 0;
	var stripesColorIndexOld = startColor;
	var stripesCounter = 0;

	for(var i=0; i<7; i++){
		
		for(var j=startPixl+i*oneUnit; j < (startPixl+i*oneUnit + oneUnit); j++)
		{
				if(imgData.data[j*4] < colorAverage) stripesColorIndex--;
				else stripesColorIndex++;
		}
		
		if(stripesColorIndex < 0) stripesColorIndex = 0;
		else stripesColorIndex = 1;
		
		if(stripesColorIndexOld == stripesColorIndex) stripesCounter++;
		else
		{
			numbers[numbers.length] = stripesCounter;
			stripesCounter = 1;
		}

		stripesColorIndexOld = stripesColorIndex;
		
	}
	numbers[numbers.length] = stripesCounter;
}

function print()
{
	var values = '';
	
	for(var i=0; i<numbers.length; i++)
		values += numbers[i];
	
	var index = '';
	
	for(var i=0; i<numbers.length; i+=4)
	{
		index = values.substring(i,i+4);

		if(!UPC_SET[index])
			document.write('%');
		else
			document.write(UPC_SET[index]);
	}
}
