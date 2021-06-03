<!DOCTYPE html>
<html>
<head>
	<title>Sign in </title>
	<link rel = "icon" href = "index.jpeg" type = "image/x-icon"> 
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
	<style type="text/css">
        
        
        .btn-primary {
            color: #fff;
            background-color: #007bff;
            border-color: #007bff;
        }
        
        .btn {
            display: inline-block;
/*
            font-weight: 400;
            color: #212529;
*/
            text-align: center;
            
/*
            background-color: transparent;
            border: 1px solid transparent;
*/
/*            padding: .375rem .75rem;*/
            font-size: 2rem;
            line-height: 1.5;
            border-radius: .25rem;
            transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;
        }
        
        
        
		#list{
			border: 2px solid black;
			text-align: center;
		}
		#frame{
			/*border: 2px solid black;*/
			padding: 50px 50px;
			/*text-align: center;
			*/width: 80%;
		}
		input[type=text],input[type=password],input[type=email],input[type=submit]{
			/*margin:auto;
			width: 90%;*/
			background-color: white;
			border: 1px solid gray;		
			display: block;
			margin-right: auto;
			margin-left: auto;
			/*margin-top: 2px;*/
			width: 93%;
			border-radius: 4px;
			padding: 6px 10px;
			color: #2e2e2e;
			background-color: #fff;
			font-family: inherit;
			transition: border-color 0.15s;
		}
		input[type=checkbox],input[type=submit]{
			margin-bottom: 17px;
		}
	</style>
	<script type="text/javascript">
		function show_sign() {
			var sign_in = document.getElementById("sign_in");
			sign_in.style.borderBottom = "2px solid purple";

			var register = document.getElementById("register");
			register.style.borderBottom = "1px solid gray";
			
			var register_form = document.getElementById("register_form");
			register_form.style.display = "none";

			var sign_in_form = document.getElementById("sign_in_form");
			sign_in_form.style.display = "block";
		}

		function show_reg() {
			var register = document.getElementById("register");
			register.style.borderBottom = "2px solid purple";

			var sign_in = document.getElementById("sign_in");
			sign_in.style.borderBottom = "1px solid gray";
			
			var register_form = document.getElementById("register_form");
			register_form.style.display = "block";

			var sign_in_form = document.getElementById("sign_in_form");
			sign_in_form.style.display = "none";
		}

		function check_if_signed(){
			var hidden = document.getElementById('hframe1');
			console.log(hidden.contentDocument.body.childNodes);
			if(hidden.contentDocument.body.childNodes[0].textContent == 1)
			{	console.log("successfully logged in");
				var success = document.getElementById('success-log');
				success.style.display = "block";
				window.setTimeout(function() {
					var success = document.getElementById('success-log');
					success.style.display = "none";
				},5000);
				//change location
				//window.location.href = "http://localhost/wt2/tickets.php";
			}
			else
			{
				var unsuccess = document.getElementById('unsuccess-log');
				unsuccess.style.display = "block";	
				window.setTimeout(function() {
					var unsuccess = document.getElementById('unsuccess-log');
					unsuccess.style.display = "none";
				},5000);
			}
		}

		function check_if_reg()
		{
			var hidden = document.getElementById('hframe');
			console.log(hidden.contentDocument.body.childNodes);
			//hidden.contentDocument.body.childNodes[0].textContent = 12;
			if(hidden.contentDocument.body.childNodes[0].textContent == 1)
			{	console.log("successfully registered");
				var success = document.getElementById('success');
				success.style.display = "block";
				window.setTimeout(function() {
					var success = document.getElementById('success');
					success.style.display = "none";
				},5000);
			}
			else
			{
				var unsuccess = document.getElementById('unsuccess');
				unsuccess.style.display = "block";	
				window.setTimeout(function() {
					var unsuccess = document.getElementById('unsuccess');
					unsuccess.style.display = "none";
				},5000);
			}
		}

		function submitform()
		{
			var name = document.getElementById('name').value;
			var password = document.getElementById('password').value;
			console.log(name + " " + password);
			var data = {
				"name" : name,
				"password" : password
			};
			var myJSON = JSON.stringify(data);
			console.log(myJSON);

			var xhr = new XMLHttpRequest();
			xhr.onreadystatechange = function()
			{
				if(xhr.readyState == 4 && xhr.status == 200)
				{
					console.log(xhr.responseText);
					if(xhr.responseText.localeCompare("1") == 0)
					{
						console.log("successfully logged in");
						var success = document.getElementById('success-log');
						success.style.display = "block";
						window.setTimeout(function() {
							var success = document.getElementById('success-log');
							success.style.display = "none";
						},5000);
						//change location
						window.location.href = "http://localhost/wt2/tickets.php";
					}
					else if(xhr.responseText.localeCompare("-1") == 0)
					{
						var unsuccess = document.getElementById('unsuccess-log');
						unsuccess.style.display = "block";	
						window.setTimeout(function() {
							var unsuccess = document.getElementById('unsuccess-log');
							unsuccess.style.display = "none";
						},5000);
					}
				}
			};
			xhr.open("POST", "http://localhost:5500/sign_in", true);
			xhr.setRequestHeader("Content-Type","application/json");
			//xhr.setRequestHeader('Access-Control-Allow-Origin','*');
			xhr.send(myJSON);
		}

		var timer_name = null;

		function check_validity_name(obj)
		{     console.log("|||||||||||||||||||");
			console.log(obj);
			console.log(obj.name);
			console.log("Typed in value is : ",obj.value);
//            var inputname = document.getElementById('inp');
//            console.log("name is::::"+" "+inputname.value);
			//var data = [obj.name];
			var data = {};
			data[obj.name] = obj.value;
			
			var myJSON = JSON.stringify(data);
			console.log(myJSON);

			if(timer_name)
			{
				clearTimeout(timer_name);
			}

			timer_name = setTimeout(function(){
				console.log("In the timer function",myJSON);

				var xhr = new XMLHttpRequest();
				xhr.onreadystatechange = function()
				{
					if(xhr.readyState == 4 && xhr.status == 200)
					{
						console.log("in supplement");
						console.log("Response is",xhr.responseText);
						var response = JSON.parse(xhr.responseText);

						if(response['name'] == 1)
						{
							document.getElementById('name_green').style.display = 'block';
							document.getElementById('name_red').style.display = 'none';
						}
						else if(response['name'] == -1)
						{
							document.getElementById('name_green').style.display = 'none';
							document.getElementById('name_red').style.display = 'block';
						}

					}
				};
				xhr.open("POST", "http://localhost:5500/check_validity", true);
				xhr.setRequestHeader("Content-Type","application/json");
				xhr.send(myJSON);

			},1000);

		}

		var timer_phone = null;

		function check_validity_phone(obj)
		{
			console.log(obj);
			console.log(obj.name);
			console.log("Typed in value is : ",obj.value);

			//var data = [obj.name];
			var data = {};
			data[obj.name] = obj.value;
			
			var myJSON = JSON.stringify(data);
			console.log(myJSON);

			if(timer_phone)
			{
				clearTimeout(timer_phone);
			}

			timer_phone = setTimeout(function(){
				console.log("In the timer function",myJSON);

				var xhr = new XMLHttpRequest();
				xhr.onreadystatechange = function()
				{
					if(xhr.readyState == 4 && xhr.status == 200)
					{
						console.log("in supplement");
						console.log("Response is",xhr.responseText);
						var response = JSON.parse(xhr.responseText);

						if(response['phone'] == 1)
						{
							document.getElementById('phone_green').style.display = 'block';
							document.getElementById('phone_red').style.display = 'none';
						}
						else if(response['phone'] == -1)
						{
							document.getElementById('phone_green').style.display = 'none';
							document.getElementById('phone_red').style.display = 'block';
						}

					}
				};
				xhr.open("POST", "http://localhost:5500/check_validity", true);
				xhr.setRequestHeader("Content-Type","application/json");
				xhr.send(myJSON);

			},1000);

		}

		var timer_sign = null;

		function check_validity_sign(obj)
		{

			//console.log(obj);
//			console.log(obj.name);
//			console.log("Typed in value is : ",obj.value);
           
            
            
            
           
			//var data = [obj.name];
			var data = {};
			data['name_sign'] = obj.value;

			var myJSON = JSON.stringify(data);
			console.log(myJSON);

			if(timer_sign)
			{
				clearTimeout(timer_sign);
			}
			timer_sign = setTimeout(function(){
				console.log("In the timer function",myJSON);

				var xhr = new XMLHttpRequest();
				xhr.onreadystatechange = function()
				{
					if(xhr.readyState == 4 && xhr.status == 200)
					{
						console.log("in supplement");
						console.log("Response is",xhr.responseText);
						var response = JSON.parse(xhr.responseText);

						if(response.length == 0)
						{
							obj.style.backgroundColor="red";
							obj.style.fontStyle="italics";

							var container = document.getElementById('list_signin');
							container.style.display="none";
						}
						else
						{
							var container = document.getElementById('list_signin');
							container.innerHTML="";

							for(var i = 0;i<response.length;i++)
							{
								var itemDiv=document.createElement("div");
								itemDiv.innerHTML=response[i];
								itemDiv.className="fooditem";
								itemDiv.onclick=setName;
								container.appendChild(itemDiv);

								itemDiv.style.backgroundColor = "grey";
								itemDiv.style.color = "black"
							}
							container.style.display="block";
							obj.style.backgroundColor="white";
						}
					}
				};
				xhr.open("POST", "http://localhost:5500/check_validity", true);
				xhr.setRequestHeader("Content-Type","application/json");
				xhr.send(myJSON);

			},5000);

		}

		function setName(e)
		{
			var search = document.getElementById('name');
			var container = document.getElementById('list_signin');

			search.value=e.target.innerHTML;
			//object.search.style.backgroundColor="white";
			container.style.display="none"
			container.innerHTML="";
		}
        
        function live_chat(){
//            var xhr=new XMLHttpRequest();
//            xhr.onreadystatechange=function(){
                window.location.href="http://127.0.0.1:5000/"
          //  }
        }

	</script>
</head>
<body>
	<!--<div class="container-fluid" id="list">List of items</div>-->
	<nav class="navbar navbar-default">
		<div class="container-fluid">
			<div class="navbar-header">
				<a class="navbar-brand" href="#">Indian Airlines</a>
			</div>
			<ul class="nav navbar-nav" style="position: relative;left: 60%;">
				<li><a href="">Welcome</a></li>
				<li><a href="">View Tickets</a></li>
				<li class="active"><a href="">Sign in</a></li>
<!--                <li><button onclick="live_chat()">Live Chat</a></li>-->
			</ul>
		</div>
	</nav>
	<div class="container" id="frame">
		<div class="col-md-6">
			<h2>MyTickets.com</h2>
			<p style="color: gray;">MyTickets.com offers free unlimited (private) repositories and unlimited collaborators.</p>
			<ul>
<!--				
<li>Explore flights on MyTickets.com (no login needed)</li>-->
				<li>More information about MyTickets.com</li>
				<li>MyTickets.com Support Forum</li>
				<li>MyTickets.com Homepage</li>
			</ul>
    		<p style="color: gray;">By signing up for and by signing in to this service you accept our:</p>
    		<ul>
    			<li>Privacy policy</li>
    			<li>MyTickets.com Terms.</li>
    		</ul>
		</div>
		<div class="col-md-6">
			<div id="form-container" style="width: 90%;margin: auto;">
				<div class="col-md-6" id="sign_in" style="border: 1px solid gray;text-align: center;padding: 13px;cursor:pointer;" onclick="show_sign()">Sign in</div>
				<div class="col-md-6" id="register" style="border: 1px solid gray;text-align: center;padding: 13px;cursor:pointer;border-bottom: 2px solid purple;" onclick="show_reg()">Register</div>
				<div id="sign_in_form" style="display: none;border: 1px solid gray;border-radius: 6px;">
					
						<label>&nbsp;&nbsp;&nbsp;Name</label><br/>
						<input type="text" id="name" name="name" required onkeypress="check_validity_sign(this)">
						<div id="list_signin" style="border:solid 1px black;display:none;"></div>
						<br/><label>&nbsp;&nbsp;&nbsp;Password</label><br/>
						<input type="password" id="password" name="password" required>
						&nbsp;&nbsp;&nbsp;
						<input type="checkbox" name="check" value="yes">Remember me<br/>
						<input type="hidden" name="RorS" value="0">
						<button id="log_btn" style="background-color: white;border: 1px solid gray;display: block;margin-right: auto;
						margin-left: auto;width: 93%;border-radius: 4px;padding: 6px 10px;color: #2e2e2e;
						background-color: #fff;font-family: inherit;transition: border-color 0.15s;
						background-color: #0CA91F;color: white;margin-bottom: 17px;" onclick="submitform()">Sign in</button>
						
					
					<label id="success-log" style="display: none;color: green;text-align: center;">Logged in!!</label>
					<label id="unsuccess-log" style="display: none;color: red;text-align: center;">Wrong creds</label>
				</div>
				<div id="register_form" style="border: 1px solid gray;border-radius: 6px;">
					<form action="http://localhost/wt2/reg.php" method="POST" target="hframe">
						<label>&nbsp;&nbsp;&nbsp;Name</label><br/>
						<input id="inp" type="text" name="name" required oninput="check_validity_name(this)">
						<label id='name_red' style="display: none;color: red;text-align: center;">Name already taken</label>
						<label id='name_green' style="display: none;color: green;text-align: center;">Name available</label>
						<br/><label>&nbsp;&nbsp;&nbsp;Password</label><br/>
						<input id="pass" type="password" name="password" required>
						<br/><label>&nbsp;&nbsp;&nbsp;Phone no</label><br/>
						<input id="phoneno" type="text" name="phone" required oninput="check_validity_phone(this)">
						<label id='phone_red' style="display: none;color: red;text-align: center;">Phone already taken</label>
						<label id='phone_green' style="display: none;color: green;text-align: center;">Phone available</label>
						<br/><label>&nbsp;&nbsp;&nbsp;Email</label><br/>
						<input id="mail" type="email" name="email" required><br/>
						&nbsp;&nbsp;&nbsp;
						<input id="chk" type="checkbox" name="check" value="yes" required>I agree to the terms and conditions<br/>
						<input type="hidden" name="RorS" value="1">
						<input type="submit" name="submit" value="Register" style="background-color: #0CA91F;color: white;">
						<iframe id="hframe" name="hframe" height="0" width="0" style="display: none;"></iframe>
					</form>					
					<label id="success" style="display: none;color: green;text-align: center;">Registration completed successfully</label>
					<label id="unsuccess" style="display: none;color: red;text-align: center;">Number or email taken!!</label>
				</div>
			</div>
		</div>
        
       
        <div style="top:0px;">
            <button onclick="live_chat()" class="btn btn-primary" style="width: 150px; height: 80px;margin-top:0px;">Chat with us</button>
        </div>
        
	</div>
</body>
</html>