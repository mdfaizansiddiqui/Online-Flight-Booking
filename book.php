 <!DOCTYPE html>
<html>
<head>
	<title>Booking</title>
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
		<div class="container-fluid" id="navigation">
			<div class="navbar-header">
				<a class="navbar-brand" href="#">Airline Tickets</a>
			</div>
			<ul class="nav navbar-nav" style="position: relative;left: 50%;">
				<li><a id="rssfeed" href="http://localhost/wt2/rss_feeds.php">RSS Feed</a></li>
				<li><a id="subscrib" href="http://localhost/wt2/subscribe.php">Subscribe</a></li>
				<li><a id="prev" href="http://localhost/wt2/history.php">Previous Bookings</a></li>
				<li><a id="ticket" href="http://localhost/wt2/tickets.php">View Tickets</a></li>
				<li class="active"><label href="" onclick="sign_out()" style="position: relative;top: 15px;cursor: pointer;">Sign out</label></li>
			</ul>
		</div>
	</nav>
	
	<div class="col-md-10" id="boxes" style="position: relative;left: 8%;border: 1px solid black;padding: 15px;">
		<div class="" id="box1" style="border: 1px solid gray;background-color: gray;padding: 10px;margin: 15px;cursor: pointer;" onclick="document.getElementById('titles').style.display = 'block';">
			<span>Enter Details</span>
			<span style="padding-left: 907px;">+</span>
			

			<div id="titles" style="position: relative;width: 20%;display: none;">
				<hr style="width: 1000px">
				<input id="mr" type="radio" name="gender" style="margin-left: 20%;" value="Mr.">
				<label>Mr.</label>
				<input type="radio" name="gender" style="margin-left: 10%;" value="Ms.">
				<label>Ms.</label>
				<input type="text" name="first-name" placeholder="First name" style="margin: 10%;margin-left: 20%;width: 900px;border: transparent;border-bottom: 1px solid blue;height: 35px;">
				<input id="last-name" type="text" name="last-name" placeholder="Last name" style="margin: 10%;margin-left: 20%;width: 900px;border: transparent;border-bottom: 1px solid blue;height: 35px;" onkeypress="load_add_ons()">
			</div>

		</div>
		<div class="" id="box2" style="border: 1px solid gray;background-color: gray;padding: 10px;margin: 15px;cursor: pointer;">
			<span>Select Add-ons</span>
			<span style="padding-left: 890px;">+</span>
		</div>
		<div class="" id="box3" style="border: 1px solid gray;background-color: gray;padding: 10px;margin: 15px;cursor: pointer;">
			<span>Payment</span>
			<span style="padding-left: 890px;">+</span>
		</div>
	</div>

	<div id="success" style="display: none;position: absolute;border: 2px solid black;left: 40%;top: 40%;background-color: brown;">
		<span id="close" style="cursor: pointer;position: relative;left: 85%;"><u>Close</u></span>
		<div style="padding: 50px;">Booking made successfully.<br> Check your email!</div>
	</div>
	
</body>


<script type="text/javascript">

	var close = document.getElementById('close');
	close.onclick = function (e) {
		var parent = e.target.parentElement.parentElement;
		console.log(parent);
		parent.style.display = 'none';
	}

	function load_add_ons()
	{  
		var data = ["Add-ons"];
		var myJSON = JSON.stringify(data);
		console.log(myJSON);

		var xhr = new XMLHttpRequest();
		xhr.onreadystatechange = function()
		{
			if(xhr.readyState == 4 && xhr.status == 200)
			{
				console.log(xhr.responseText);
				    eval(xhr.responseText);
			}
		};
		xhr.open("POST", "http://localhost:5500/load_box", true);
		xhr.setRequestHeader("Content-Type","application/json");
		xhr.send(myJSON);

		document.getElementById('last-name').onkeypress = function(){console.log("On key press");};

	}

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

	
	

</script>
</html>