<!DOCTYPE html>
<html>
<head>
	<title>View Bookings</title>
	<link rel = "icon" href = "index.jpeg" type = "image/x-icon"> 
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
	<style type="text/css">
	</style>
</head>
<body>
	<nav class="navbar navbar-default">
		<div class="container-fluid">
			<div class="navbar-header">
				<a class="navbar-brand" href="#">My Bookings</a>
			</div>
			<ul class="nav navbar-nav" style="position: relative;left: 50%;">
				<li><a id="rssfeed" href="http://localhost/wt2/rss_feeds.php">RSS Feed</a></li>
				<li><a id="subscrib" href="http://localhost/wt2/subscribe.php">Subscribe</a></li>
				<li><a id="ticket" href="http://localhost/wt2/tickets.php">View Tickets</a></li>
				<li class="active"><label href="" onclick="sign_out()" style="position: relative;top: 15px;cursor: pointer;">Sign out</label></li>
					
			</ul>
		</div>
	</nav>

	<div id="hotels">
		
	</div>

	<div id="success" style="display: none;position: fixed;border: 2px solid black;left: 40%;top: 40%;background-color: brown;">
		<span id="close" style="cursor: pointer;position: relative;left: 85%;"><u onclick="close_div()">Close</u></span>
		<div style="padding: 50px;">Booking cancelled successfully and Balance restored.<br> Check your email!</div>
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


	function close_div()
	{
		var success = document.getElementById('success');
		success.style.display = 'none';
	}


	function load()
	{
		xhr = new XMLHttpRequest();
		xhr.onreadystatechange = function()
		{
			if(xhr.readyState == 4 && xhr.status == 200)
			{
				//console.log(xhr.responseText);
				
				var response = JSON.parse(xhr.responseText);
				var length = Object.keys(response).length;
				console.log(response);
				console.log(length);
				
				for(var i = 0;i<length;i++)
				{
					console.log(response[i]);

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
					img.src = './bombay.jpg';
					img.style.maxHeight = '100%';
					img.style.maxWidth = '100%';
					first_half.appendChild(img);
					var h2 = document.createElement('h2');
					h2.textContent = temp[1];
					var h4 = document.createElement('h4');
					h4.textContent = "Rs." + temp[2] + " only";
					var h5 = document.createElement('h5');
					h5.textContent = temp[0];
					h5.style.display = 'none';
					second_half.appendChild(h2);
					second_half.appendChild(h4);
					second_half.appendChild(h5);
					////////////////////////////////
					var h5 = document.createElement('h5');
					h5.textContent = temp[3];
					second_half.appendChild(h5);
					var h5 = document.createElement('h5');
					var temp_string = temp[4].split(":");
					var tempo = "";
					for(var k = 0;k<temp_string.length;k++)
						tempo = tempo + temp_string[k] + " ";
					h5.textContent = tempo;
					second_half.appendChild(h5);
					/*var h3 = document.createElement('button');
					h3.textContent = "Cancel Booking";
					h3.onclick = function(e)
					{};
					third_half.appendChild(h3);*/
					hotel_card.appendChild(first_half);
					hotel_card.appendChild(second_half);
					hotel_card.appendChild(third_half);
					hotel_card.style.border = '1px solid gray';
					hotel_card.style.borderRadius = '8px';
					hotel_card.style.padding = '25px';
					hotel_card.style.margin = '10px';
					hotel_card.style.cursor = 'pointer';
					hotel_card.style.width = '90%';
					hotel_card.style.left = '50px';

					var hotels_div = document.getElementById('hotels');
					hotels_div.appendChild(hotel_card);

				}
			}
		};
		xhr.open("GET", "http://localhost:5500/load_history", true);
		xhr.send();
	}

	window.onload = load();
</script>
</html>