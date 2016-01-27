var i = 0;
		var path = new Array();
		 
		// LIST OF IMAGES
		path[0] = "banner/large_banner.jpg";
		path[1] = "banner/large_banner_1.jpg";
		path[2] = "banner/large_banner_2.jpg";
		path[3] = "banner/large_banner_3.jpg";
		path[4] = "banner/large_banner_4.jpg";
		

		function swapImage()
		{
		   document.slide.src = path[i];
		   if(i < path.length - 1) i++; else i = 0;
		   setTimeout("swapImage()",5000);
		}