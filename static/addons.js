var hr = document.createElement('hr');
hr.style.width = '1000px';
document.getElementById('box2').appendChild(hr);


var snacks = document.createElement('div');
var text = document.createElement('span');
text.textContent = "Get Snacks";
var button1 = document.createElement('button');
button1.textContent = "Add to ticket";
button1.id = "snacks";
button1.className = "addon";
button1.style.marginLeft = '800px';
button1.onclick = function()
{
//	console.log("Disabling button");
//	console.log(button1);
	button1.disabled = true;

	//if(document.getElementById('box3').childNodes[5].textContent.localeCompare("Make Payment") != 0)
	//send_request();
};
snacks.appendChild(text);
snacks.appendChild(button1);
document.getElementById('box2').appendChild(snacks);

var prime = document.createElement('div');
var text = document.createElement('span');
text.textContent = "Get Prime:-";
var button = document.createElement('button');
button.textContent = "Add to ticket";
button.id = "prime";
button.className = "addon";
button.style.marginLeft = '800px';
button.onclick = function()
{
//	console.log("Disabling button");
//	console.log(button);
	button.disabled = true;

	//if(document.getElementById('box3').childNodes[5].textContent.localeCompare("Make Payment") != 0)
	send_request();
};
prime.appendChild(text);
prime.appendChild(button);
document.getElementById('box2').appendChild(prime);

    var dont=document.createElement('div');
    var but = document.createElement("button");
    but.style.marginLeft='880px';
    but.className="addon";
    //but.id="prime";
    but.innerHTML='No thanks!';
    dont.appendChild(but);
    but.onclick=function(){
        but.disabled=true;
        send_request();
    }
    document.getElementById('box2').appendChild(dont);
function send_request()
{
	var data = ["Payment"];
	var myJSON = JSON.stringify(data);
	console.log(myJSON);

	var xhr = new XMLHttpRequest();
	xhr.onreadystatechange = function()
	{
		if(xhr.readyState == 4 && xhr.status == 200)
		{
			//console.log(xhr.responseText);
			eval(xhr.responseText);
		}
	};
	xhr.open("POST", "http://localhost:5500/load_box", true);
	xhr.setRequestHeader("Content-Type","application/json");
	xhr.send(myJSON);
}