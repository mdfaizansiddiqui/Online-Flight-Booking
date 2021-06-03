console.log("Hello from static folder");

var controls = document.createElement('div');
controls.className = "col-md-2";
controls.id = "controls";
controls.style.position = "fixed";
var h3 = document.createElement('h3');
h3.textContent = "Filters";
var h4 = document.createElement('h4');
h4.textContent = "From";
h4.style.textAlign = "center";
h4.style.fontFamily = "helvetica";

controls.appendChild(h3);
controls.appendChild(h4);
document.getElementsByTagName('body')[0].appendChild(controls);

var from = ["Bangalore","Chennai","Bombay","Kolkata","Hyderabad","Delhi"]
for(var i = 0;i<from.length;i++)
{
	var input = document.createElement('input');
	input.type = "checkbox";
	input.className = "city_from";
	input.name = "city";
	input.value = from[i];
    input.id = "f"+i;
	input.onclick = check_from;
//	input.onclick = "";

	var label = document.createElement('span');
	label.textContent = from[i];

	controls.appendChild(input);
	controls.appendChild(label);
	controls.appendChild(document.createElement('br'));
}

var h4 = document.createElement('h4');
h4.textContent = "To";
h4.style.textAlign = "center";
h4.style.fontFamily = "helvetica";

controls.appendChild(h4);

var to = ["Bangalore","Chennai","Bombay","Kolkata","Hyderabad","Delhi"]
for(var i = 0;i<to.length;i++)
{
	var input = document.createElement('input');
	input.type = "checkbox";
	input.className = "city_to";
	input.name = "city";
	input.value = to[i];
	input.onclick = check_to;
//	input.onclick = "";

	var label = document.createElement('span');
	label.textContent = to[i];

	controls.appendChild(input);
	controls.appendChild(label);
	controls.appendChild(document.createElement('br'));

}

var h4 = document.createElement('h4');
h4.textContent = "Cost";
h4.style.textAlign = "center";
h4.style.fontFamily = "helvetica";

controls.appendChild(h4);

var section = document.createElement('section');
section.className = "range-slider";
controls.appendChild(section);

var span = document.createElement('span');
span.className = "rangeValues";
section.appendChild(span);
var input1 = document.createElement('input');
input1.type = "range";
input1.className = "slide";
input1.min = "1000";
input1.max = "5000";
input1.value = "2000";
input1.step = "300";
input1.oninput = getVals;
input1.onblur = check_cost;
section.appendChild(input1);

var input2 = document.createElement('input');
input2.type = "range";
input2.className = "slide";
input2.min = "1000";
input2.max = "5000";
input2.value = "4000";
input2.step = "300";
input2.oninput = getVals;
input2.onblur = check_cost;
section.appendChild(input2);


	//only for the slider

function getVals(){
	// Get slider values
	var parent = this.parentNode;
	var slides = document.getElementsByClassName("slide");
	var slide1 = parseFloat( slides[0].value );
	var slide2 = parseFloat( slides[1].value );
	
	// Neither slider will clip the other, so make sure we determine which is larger
	if( slide1 > slide2 ){ var tmp = slide2; slide2 = slide1; slide1 = tmp; }
	console.log(slide1+" "+slide2);

	var displayElement = document.getElementsByClassName("rangeValues")[0];
	displayElement.innerHTML = slide1 + " - " + slide2;
}

function check_from()
{
	var checkboxes = document.getElementsByClassName('city_from');
	var checked=[];
	for (var i = 0; i < checkboxes.length; i++) {
		if(checkboxes[i].checked==true)
			checked.push(checkboxes[i].value);
        
//		  console.log(checkboxes[i].value);
	}
	//console.log("Checked is "+checked);

	var temp_array = []
	var restore = []
    console.log("checked length"+checked.length)

	if(checked.length>0)
	{
		var second_halfs = document.getElementsByClassName('second-half');
		for(var i = 0;i<second_halfs.length;i++)
		{
            console.log("hiiiiiiii");   
			console.log(second_halfs[i].childNodes[0].textContent);
			var flag = 0;
			for(var j=0;j<checked.length;j++)
			{
				if(second_halfs[i].childNodes[0].textContent.split("-")[0].localeCompare(checked[j])==0)
				{	
					flag = 1;
					restore.push(i);
					/*//
					parent = second_halfs[temp_array[i]].parentElement;
					parent.style.display='block';
					//*/
					break;
				}
			}
			if(flag==0)
			{
				temp_array.push(i);
				//parent = second_halfs[i].parentElement;
				//parent.remove();
			}
		}
		for(var i=0;i<temp_array.length;i++)
		{
			parent = second_halfs[temp_array[i]].parentElement;
			//parent.remove();
			parent.style.display='none';
		}

		for(var i=0;i<restore.length;i++)
		{
			parent = second_halfs[restore[i]].parentElement;
			//parent.remove();
			parent.style.display='block';
		}
	}
	else if(checked.length==0)
	{
		var second_halfs = document.getElementsByClassName('second-half');
		for(var i = 0;i<second_halfs.length;i++)
		{
			if(second_halfs[i].parentElement.style.display=='none')
				second_halfs[i].parentElement.style.display='block';
		}
	}

	//unset others
	var city_to = document.getElementsByClassName('city_to');
	for(var i = 0;i<city_to.length;i++)
	{
		city_to[i].checked = false;
	}



	var slides = document.getElementsByClassName("slide");
	slides[0].value = 1000;
	slides[1].value = 5000;



}

function check_to()
{
	var checkboxes = document.getElementsByClassName('city_to');
	var checked=[];
	for (var i = 0; i < checkboxes.length; i++) {
		if(checkboxes[i].checked==true)
			checked.push(checkboxes[i].value);
		//console.log(checkboxes[i].value);
	}
	console.log("Checked is "+checked);

	var temp_array = []
	var restore = []

	if(checked.length>0)
	{
		var second_halfs = document.getElementsByClassName('second-half');
		for(var i = 0;i<second_halfs.length;i++)
		{
			console.log(second_halfs[i].childNodes[1].textContent);
			var flag = 0;
			for(var j=0;j<checked.length;j++)
			{
                //var placeName =second_halfs[i].childNodes[0].textContent.split("-")[1] it gives place which we selected as destination
				if(second_halfs[i].childNodes[0].textContent.split("-")[1].localeCompare(checked[j])==0)
				{	
					flag = 1;
					restore.push(i);
					/*//
					parent = second_halfs[temp_array[i]].parentElement;
					parent.style.display='block';
					//*/
					break;
				}
			}
            
			if(flag==0)
			{
				temp_array.push(i);
				//parent = second_halfs[i].parentElement;
				//parent.remove();
			}
		}
		for(var i=0;i<temp_array.length;i++)
		{
			parent = second_halfs[temp_array[i]].parentElement;
			//parent.remove();
			parent.style.display='none';
		}

		for(var i=0;i<restore.length;i++)
		{
			parent = second_halfs[restore[i]].parentElement;
			//parent.remove();
			parent.style.display='block';
		}
	}
	else if(checked.length==0)
	{
		var second_halfs = document.getElementsByClassName('second-half');
		for(var i = 0;i<second_halfs.length;i++)
		{
			if(second_halfs[i].parentElement.style.display=='none')
				second_halfs[i].parentElement.style.display='block';
		}
	}

	//unset others
	var city_from = document.getElementsByClassName('city_from');
	for(var i = 0;i<city_from.length;i++)
	{
		city_from[i].checked = false;
	}



	var slides = document.getElementsByClassName("slide");
	slides[0].value = 1000;
	slides[1].value = 5000;

}

function check_cost()
{
	var slides = document.getElementsByClassName("slide");
	var slide1 = parseFloat( slides[0].value );
	var slide2 = parseFloat( slides[1].value );
	var temp_array = []
	var restore = []

	var second_halfs = document.getElementsByClassName('second-half');
	for(var i = 0;i<second_halfs.length;i++)
	{
		var cost = second_halfs[i].childNodes[1].textContent.split(" ")[0].split(".")[1];

		if(cost>=slide1 && cost<=slide2)
			restore.push(i);
		else
			temp_array.push(i);
	}

	for(var i=0;i<temp_array.length;i++)
	{
		parent = second_halfs[temp_array[i]].parentElement;
		//parent.remove();
		parent.style.display='none';
	}

	for(var i=0;i<restore.length;i++)
	{
		parent = second_halfs[restore[i]].parentElement;
		//parent.remove();
		parent.style.display='block';
	}

	//unset others
	var city_from = document.getElementsByClassName('city_from');
	for(var i = 0;i<city_from.length;i++)
	{
		city_from[i].checked = false;
	}

	//unset others
	var city_to = document.getElementsByClassName('city_to');
	for(var i = 0;i<city_to.length;i++)
	{
		city_to[i].checked = false;
	}
}





































/*
document.getElementById('tickets').style.overflow = "scroll";
//document.getElementById('tickets').style.overflowX = "hidden";
document.getElementById('tickets').style.height = "580px";


console.log("Client Height of tickets is : ",document.getElementById('tickets').clientHeight);
console.log("Scroll Height of tickets is : ",document.getElementById('tickets').scrollHeight);
console.log("Offset Height of tickets is : ",document.getElementById('tickets').offsetHeight);
console.log("Window client height is : ",document.documentElement.clientHeight);


document.getElementById('tickets').onscroll = function ()
{	
	var tickets = document.getElementById('tickets');

	console.log("Scrolling");
	console.log('Scrolled amount is : ',document.getElementById('tickets').scrollTop);
	if(tickets.scrollHeight - tickets.scrollTop === tickets.clientHeight)
	{
		console.log("Difference is : ",tickets.scrollHeight - tickets.scrollTop);
	}
};

*/

/*

xhr=new XMLHttpRequest();
scrollAmt=500;
count=5;
function getChunk(){
	scroll=document.body.scrollTop||document.documentElement.scrollTop;
	if(scroll>scrollAmt){
		console.log("in getchunk . count is "+count);
		scrollAmt=scroll;
		xhr.onreadystatechange=showChunk;
		xhr.open("GET","http://localhost/SE/getChunk.php?count="+count,true);
		xhr.send();
		count = count +5;
	}
}
function showChunk(){
	//console.log(xhr.status)
	if(xhr.readyState==4 && xhr.status==200){
		console.log("hello from showChunk");
		
		console.log(xhr.responseText);
		if(xhr.responseText.localeCompare("No") != 0)
		{

			var res = xhr.responseText.split(";");
			console.log(res);

			if(res.length>1)
			{
				for (var i = 0; i < res.length; i++) {
					var temp = res[i].split(":");
					console.log(temp);

					if(temp.length>1)
					{

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
						h4.textContent = temp[2];
						var h5 = document.createElement('h5');
						h5.textContent = temp[3]+"/5";
						second_half.appendChild(h2);
						second_half.appendChild(h4);
						second_half.appendChild(h5);
						var h3 = document.createElement('h3');
						h3.textContent = "Rs. "+temp[4]+"/- only";
						third_half.appendChild(h3);
						hotel_card.appendChild(first_half);
						hotel_card.appendChild(second_half);
						hotel_card.appendChild(third_half);
						hotel_card.style.border = '1px solid gray';
						hotel_card.style.borderRadius = '8px';
						hotel_card.style.padding = '25px';
						hotel_card.style.margin = '10px';
						hotel_card.style.cursor = 'pointer';
						hotel_card.onclick = function(e){

							var name = e.target.childNodes[1].childNodes[0].textContent;
							var location = e.target.childNodes[1].childNodes[1].textContent;
							var review = e.target.childNodes[1].childNodes[2].textContent;
							var cost = e.target.childNodes[2].childNodes[0].textContent;
							console.log(name+location+review+cost);

							document.cookie = "username="+name+":"+location+":"+review+":"+cost+";expires=Thu, 31 Oct 2019 12:00:00 UTC; path=/";
							window.location.href = "http://localhost/SE/book.php";

						};
						var hotels_div = document.getElementById('hotels');
						hotels_div.appendChild(hotel_card);
					}
				}
			}
		}
		else
		{
			console.log("It is equal to zero!!");
			console.log(xhr.responseText.localeCompare("No"));

		}
	
	}

}
window.onscroll=getChunk;

*/