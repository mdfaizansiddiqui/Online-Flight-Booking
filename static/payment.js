var payment_button = document.createElement('button');
payment_button.textContent = "Make Payment";
payment_button.id="pay"
payment_button.onclick = make_payment;
payment_button.style.position = "relative";
payment_button.style.marginLeft = "45%";

document.getElementById('box3').appendChild(payment_button);


var n = 2;

function make_payment()
{	
	var addons = [];
	var string = "";

	var buttons = document.getElementsByClassName('addon');
	for(var i = 0;i<buttons.length;i++)
	{
		if(buttons[i].disabled == true)
		{
			id = buttons[i].id;
			addons.push(id);
			string = string + id + ":";
		}

	}
	console.log(addons);

	var cookie = document.cookie;
	console.log(cookie);

	individual_cookies = cookie.split(";");
	console.log(individual_cookies);

	var flightid = "";
	var cost = "";

	for(var i = 0;i<individual_cookies.length;i++)
	{
		var temp = individual_cookies[i].split('=');
		console.log(temp[0]);
		if(temp[0].localeCompare(" flightIdCost") == 0 || temp[0].localeCompare("flightIdCost") == 0)
		{
			flightid = temp[1].split(":")[0];
			cost = temp[1].split(":")[1];
		}
	}

	console.log("Flight id is ",flightid);
	console.log("Cost  is ",cost);

	var inputs = document.getElementsByTagName('input');
	var full_name = "";
	for(var i = 0;i<inputs.length;i++)
	{
		if(inputs[i].type == "radio")
		{
			if(inputs[i].checked == true)
				full_name = full_name + inputs[i].value + " ";
		}
		else
			full_name = full_name + inputs[i].value + " ";
	}

	var data = {
		"fullname": full_name,
		"flightid": flightid,
		"cost": cost,
		"addons": string
	};

	var myJSON = JSON.stringify(data);
	console.log(myJSON);

	var xhr = new XMLHttpRequest();
	xhr.onreadystatechange = function()
	{
		if(xhr.readyState == 4 && xhr.status == 200)
		{
			console.log(xhr.responseText);
			if(xhr.responseText.localeCompare("Less balance") == 0)
			{
				var success = document.getElementById('success');
				success.style.display = 'block';
				success.childNodes[3].textContent = "Booking has been rejected due to low balance.";

			}
			else
			{
				show_success(xhr.responseText);
			}
		}
	};
	xhr.open("POST", "http://localhost:5500/make_booking", true);
	xhr.setRequestHeader("Content-Type","application/json");

	/*xhr.timeout = 2000;
	xhr.ontimeout=backoff;*/
	xhr.send(myJSON);
}

function show_success(response)
{
	var success = document.getElementById('success');
	success.style.display = 'block';
	success.childNodes[3].innerHTML += "Discount received is : " + response + "%.";
}

/*function backoff(){
	console.log("failed")
	n=n*2;
	console.log(n);
	setTimeout(make_payment,n*1000);

}
*/