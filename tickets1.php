<!DOCTYPE html>
<html>
<head>
	<title>Tickets</title>
	<link rel = "icon" href = "index.jpeg" type = "image/x-icon"> 
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
	<style type="text/css">

	</style>

	<script>
	/////////////////////////////////////////////////////////
	/////////////////////////////////////////////////////////
	/////////////////////////////////////////////////////////

		function updateCash(data,time)
		{
			
			
			var second_halfs  = document.getElementsByClassName('second-half');
			console.log(second_halfs);
			console.log("Length of second_halfs is : ",second_halfs.length);

			for(var i = 0;i<second_halfs.length;i++)
			{
				var h4 = second_halfs[i].childNodes[1];
				console.log("Child node is : ",h4.textContent);

				h4.textContent = "Rs." + data + " not only";
			}

			obj.t=time;
		}

		var obj=
		{
			xhr:new XMLHttpRequest(),
			t:0,
			getData:function()
			{
				this.xhr.onreadystatechange=this.showData;
				this.xhr.open("GET","xhr_lp.php?time="+this.t,true);
				this.xhr.send();
			},
			showData:function()
			{
				if(this.readyState==4 && this.status==200)
				{
					var res=this.responseText;
					console.log("Long Polling result is : ",res);
					if(res.indexOf("Fatal")== -1)	
					{
						var resArr=res.split(";");
						  
						updateCash(resArr[0],resArr[1]);
					
					}
				 	//obj.getData(obj.t);
				}
			}
		}
	/////////////////////////////////////////////////////////
	/////////////////////////////////////////////////////////
	/////////////////////////////////////////////////////////

</script>
</head>
<body onload="load_five()">
	<nav class="navbar navbar-default">
		<div class="container-fluid" id="navigation">
			<div class="navbar-header">
				<a class="navbar-brand" href="#">Airline Tickets</a>
			</div>
			<ul class="nav navbar-nav" style="position: relative;left: 0%;">
				<li><a href="http://localhost/wt2/rss_feeds.php">RSS Feed</a></li>
				<li><a href="http://localhost/wt2/subscribe.php">Subscribe</a></li>
				<li><a href="http://localhost/wt2/history.php">Previous Bookings</a></li>
				<li><a href="">View Tickets</a></li>
				<li class="active"><label href="" onclick="sign_out()" style="position: relative;top: 15px;cursor: pointer;">Sign out</label></li>
			</ul>
		</div>
	</nav>
	
	<div class="big-container" style="">
		<div class="col-md-2" id="controls" style="position: fixed;"></div>
		<div class="col-md-10" id="tickets" style="position: relative;left: 16%;"></div>
	</div>

</body>
<script type="text/javascript">

	function sign_out()
	{
		var xhr = new XMLHttpRequest();
		xhr.onreadystatechange = function()
		{
			if(xhr.readyState == 4 && xhr.status == 200)
			{
				console.log("Signed out is : ",xhr.responseText);
				window.location.href = "http://localhost/wt2/sign_in.php";
			}
		};
		xhr.open("GET", "http://localhost:5500/sign_out", true);
		xhr.send();
	}

	function changeTickets()
	{
		document.getElementById('tickets').style.overflow = "scroll";
		//document.getElementById('tickets').style.overflowX = "hidden";
		document.getElementById(  'tickets').style.height = "580px";


		console.log("Client Height of tickets is : ",document.getElementById('tickets').clientHeight);
		console.log("Scroll Height of tickets is : ",document.getElementById('tickets').scrollHeight);
		console.log("Offset Height of tickets is : ",document.getElementById('tickets').offsetHeight);
		console.log("Window client height is : ",document.documentElement.clientHeight);


		document.getElementById('tickets').onscroll = function ()
		{	
			var tickets = document.getElementById('tickets');

//			console.log("Scrolling");
//			console.log('Scrolled amount is : ',document.getElementById('tickets').scrollTop);
			if(tickets.scrollHeight - tickets.scrollTop === tickets.clientHeight)
			{
				console.log("Difference is : ",tickets.scrollHeight - tickets.scrollTop);

				var xhr = new XMLHttpRequest();
				xhr.onreadystatechange = function()
				{
					if(xhr.readyState == 4 && xhr.status == 200)
					{
						console.log("Loading more tickets is : ",xhr.responseText);
						var response = JSON.parse(xhr.responseText);
						var length = Object.keys(response).length;

						for(var i = 0;i<length;i++)
						{
							//console.log(response[i]);
							var temp = response[i];

							var hotel_card = document.createElement('div');//for loading tickets, each ticket has different card(border)
							var first_half = document.createElement('div');// child div in hotel_card to load image
							var second_half = document.createElement('div');
                            //child div of hotel card ,loads middle part of ticket i.e src-dest and price of ticket
							var third_half = document.createElement('div');//to display book now button
                            
                            
							hotel_card.classList.add('col-md-12');
							hotel_card.classList.add('hotel-card');
                            
							first_half.classList.add('col-md-3');
							first_half.classList.add('first-half');
                            
							second_half.classList.add('col-md-6');
							second_half.classList.add('second-half');
                            
							third_half.classList.add('col-md-3');
							third_half.classList.add('third-half');
                            
							var img = document.createElement('img');
							img.src = './bombay.jpg';
							img.style.maxHeight = '100%';
							img.style.maxWidth = '100%';
							first_half.appendChild(img);
                            ////////
							var h2 = document.createElement('h2');
							h2.textContent = temp[1] + "-" + temp[2];
							var h4 = document.createElement('h4');
							h4.textContent = "Rs." + temp[3] + " only";
                            
							var hidden = document.createElement('h5');
							hidden.textContent = temp[0];
							hidden.style.display = 'none';
                            
							second_half.appendChild(h2);
							second_half.appendChild(h4);
							second_half.appendChild(hidden);
                            /////////
							var h3 = document.createElement('button');
							h3.textContent = "Book now";
							h3.onclick = function (e) {
								var flightid = e.target.parentElement.parentElement.childNodes[1].childNodes[2].textContent;
								var cost = e.target.parentElement.parentElement.childNodes[1].childNodes[1].textContent.split(" ")[0].split(".")[1];
                                
								console.log(cost);
								console.log(flightid);
								document.cookie = "flightIdCost="+flightid+":"+cost+"; expires=Thu, 18 Dec 2020 12:00:00 UTC; path=/";
								window.location.href = 'http://localhost/wt2/book.php';
							};
							third_half.appendChild(h3);
                            ///////////
                                
							hotel_card.appendChild(first_half);
							hotel_card.appendChild(second_half);
							hotel_card.appendChild(third_half);
                            
							hotel_card.style.border = '1px solid gray';
							hotel_card.style.borderRadius = '8px';
							hotel_card.style.padding = '25px';
							hotel_card.style.margin = '10px';
							hotel_card.style.cursor = 'pointer';
							
    							var hotels_div = document.getElementById('tickets');
    							hotels_div.appendChild(hotel_card);
						}
						//setTimeout(fillImages,500);


					}
				};
				xhr.open("GET", "http://localhost:5500/load_more_tickets", true);
				xhr.send();

			}
		};

	}

    


	function load_five()
	{
		var data = {
			"count": 0
		};
		var myJSON = JSON.stringify(data);
		console.log(myJSON);

		var xhr = new XMLHttpRequest();
		xhr.onreadystatechange = function()
		{
			if(xhr.readyState == 4 && xhr.status == 200)
			{
				//console.log(xhr.responseText);
				response = JSON.parse(xhr.responseText);
				//console.log("Decoded JSON is : ",response);
				//console.log("Length is : ",Object.keys(response).length);
				var length = Object.keys(response).length;

				for(var i = 0;i<length;i++)
				{
					//console.log(response[i]);
					var temp = response[i];

					var hotel_card = document.createElement('div');
					var first_half = document.createElement('div');
					var second_half = document.createElement('div');
					var third_half = document.createElement('div');
					hotel_card.classList.add('col-md-12');
					hotel_card.classList.add('hotel-card');
					first_half.classList.add('col-md-3');
					first_half.classList.add('first-half');
					second_half.classList.add('col-md-6');
					second_half.classList.add('second-half');
					third_half.classList.add('col-md-3');
					third_half.classList.add('third-half'); 
                    
					var img = document.createElement('img');
					//img.src = './bombay.jpg';
					img.style.maxHeight = '100%';
					img.style.maxWidth = '100%';
					first_half.appendChild(img);
                    
					var h2 = document.createElement('h2');
				    h2.textContent = temp[1] + "-" + temp[2];
					var h4 = document.createElement('h4');
					h4.textContent = "Rs." + temp[3] + " only";
					var hidden = document.createElement('h5');
					hidden.textContent = temp[0];
					hidden.style.display = 'none';
					second_half.appendChild(h2);
					second_half.appendChild(h4);
					second_half.appendChild(hidden);
                    
                    
					var h3 = document.createElement('button');
					h3.textContent = "Book now";
					h3.onclick = function (e) {
						var flightid = e.target.parentElement.parentElement.childNodes[1].childNodes[2].textContent;
						var cost = e.target.parentElement.parentElement.childNodes[1].childNodes[1].textContent.split(" ")[0].split(".")[1];
						console.log(cost);
						console.log(flightid);
						document.cookie = "flightIdCost="+flightid+":"+cost+"; expires=Thu, 18 Dec 2020 12:00:00 UTC; path=/";
						window.location.href = 'http://localhost/wt2/book.php';
					};
					third_half.appendChild(h3);
                    
					hotel_card.appendChild(first_half);
					hotel_card.appendChild(second_half);
					hotel_card.appendChild(third_half);
                    
					hotel_card.style.border = '1px solid gray';
					hotel_card.style.borderRadius = '8px';
					hotel_card.style.padding = '25px';
					hotel_card.style.margin = '10px';
					hotel_card.style.cursor = 'pointer';
					
					var hotels_div = document.getElementById('tickets');
					hotels_div.appendChild(hotel_card);
				}
				setTimeout(fillImages,500);

				changeTickets();
			}
		};
		xhr.open("POST", "http://localhost:5500/load_tickets", true);
		xhr.setRequestHeader("Content-Type","application/json");
		xhr.send(myJSON);


		/////////////////////////////////////////////////////////////////
		/////////////////////////////////////////////////////////////////
		/////////////////////////////////////////////////////////////////

		obj.getData();

		/////////////////////////////////////////////////////////////////
		/////////////////////////////////////////////////////////////////
		/////////////////////////////////////////////////////////////////

	}

	function fillImages()
	{
		//console.log("Requesting for images");
		var xhr = new XMLHttpRequest();
		xhr.onreadystatechange = function()
		{
			if(xhr.readyState == 4 && xhr.status == 200)
			{
				console.log("Is this base 64??");
				console.log(xhr.responseText);
				response = JSON.parse(xhr.responseText);
				//console.log("Decoded JSON is : ",response["image"]);
				var images = document.getElementsByTagName('img');
				for(var i = 0;i<images.length;i++)
					images[i].src = "data:image/jpg;base64," + response["image"];
			}
		};
		xhr.open("GET", "http://localhost:5500/load_images", true);
		xhr.send();

		setTimeout(getFilter,500);
	}

	function getFilter()
	{
		//console.log("Requesting for filters");
		var xhr = new XMLHttpRequest();
		xhr.onreadystatechange = function()
		{
			if(xhr.readyState == 4 && xhr.status == 200)
			{
				//console.log(xhr.responseText);
				eval(xhr.responseText);
			}
		};
		xhr.open("GET", "http://localhost:5500/get_filters", true);
		xhr.send();

		setTimeout(getCss,1000);

	}

	function getCss()
	{
		//console.log("Requesting to apply style");
		var xhr = new XMLHttpRequest();
		xhr.onreadystatechange = function()
		{
			if(xhr.readyState == 4 && xhr.status == 200)
			{
				//console.log(xhr.responseText);
				//console.log("Resetting style");
				var style = document.createElement('style');
				style.textContent = xhr.responseText;
				document.getElementsByTagName('head')[0].appendChild(style);
			}
		};
		xhr.open("GET", "http://localhost:5500/get_css", true);
		xhr.send();

	}

	


</script>
</html>