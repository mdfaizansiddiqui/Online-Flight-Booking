<!DOCTYPE html>
<html>
<head>
	<title>Subscribe to RSS</title>
	<link rel = "icon" href = "index.jpeg" type = "image/x-icon"> 
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
	<style type="text/css">

	</style>
	<script>
	
		function updateRss(data,time)
		{
			console.log("Updating RSS : ",data);
			
			//update_page('indigo',data);
		}

		var obj_new=
		{
			xhr:new XMLHttpRequest(),
			t:0,
			flag:0,
			getData:function()
			{
				this.xhr.onreadystatechange=this.showData;
				this.xhr.open("GET","rss_lp.php?time="+this.t,true);
				this.xhr.send();
			},
			showData:function()
			{
				if(this.readyState==4 && this.status==200)
				{
					var res=this.responseText;
//					console.log("Long Polling result is : ",res);
					if(res.indexOf("Fatal")== -1)	
					{

						var resArr=res.split("-----");	
						console.log(resArr);
						obj_new.t=resArr[1];
						console.log("New time is ",obj_new.t);
						var parser, xmlDoc;
						parser = new DOMParser();
						xmlDoc = parser.parseFromString(resArr[0],"text/xml");
						var big_container = document.getElementsByClassName('big-container')[0]; //displaying rss feeds on container
//                        console.log(big_container);
                        console.log("childnodes of big container are      "+big_container.childNodes.length)
						for(var i = 3;i<big_container.childNodes.length;i++)
						{
                            console.log(big_container);
                          
							var temp = big_container.childNodes[i];
							console.log(temp);
							//var p = document.createElement('p');
                            
							if(temp.childNodes[0].textContent.localeCompare("INDIGO") == 0)
							{
//								console.log(temp);
								temp.style.display = "none";
								//big_container.removeChild(temp);
							}
						}

						if(obj_new.flag == 0)
						{
							obj_new.flag = 1;	
						}
						else
						{
							//updateRss(resArr[0],resArr[1]);
							update_page('indigo',xmlDoc);
						}
					}
//				 	obj_new.getData(obj_new.t);
				}
			}
		}
	
	</script>
</head>
<body onload="init()">
	<nav class="navbar navbar-default">
		<div class="container-fluid" id="navigation">
			<div class="navbar-header">
				<a class="navbar-brand" href="#">Airline Tickets</a>
			</div>
			<ul class="nav navbar-nav" style="position: relative;left: 50%;">
				<li><a href="http://localhost/wt2/subscribe.php">Subscribe</a></li>
				<li><a href="http://localhost/wt2/history.php">Previous Bookings</a></li>
				<li><a href="http://localhost/wt2/tickets.php">View Tickets</a></li>
				<li id="logout" class="active"><label href="" onclick="sign_out()" style="position: relative;top: 15px;cursor: pointer;">Sign out</label></li>
			</ul>
		</div>
	</nav>
	
	<div class="big-container col-md-8" style="position: relative;margin-left: 20%;border: 2px solid black;padding: 20px;">
		<p>RSS Feeds</p>
	</div>

</body>
<script type="text/javascript">

function init()
{
	obj = new News();
	obj.divinner = document.getElementsByClassName("big-container")[0];
//
	setTimeout(obj.getNews,1000);
    
//    console.log("hii");
}

function News()
{
	var xhr = new XMLHttpRequest();

	this.getNews = function()
	{
		//var xhr = new XMLHttpRequest();
		xhr.onreadystatechange = obj.processNews;
		xhr.open("GET", "http://localhost:5500/get_rss", true);
		xhr.send();
	}
	
	this.processNews = function()
	{  
		if(xhr.readyState == 4 && xhr.status == 200)
		{
			//console.log(xhr.responseText);
			//console.log(xhr.getAllResponseHeaders());

			var response = JSON.parse(xhr.responseText);
			//console.log(response);

			for(var i = 0;i<response.length;i++)
			{
				get_rss(response[i]);
			}

				console.log("new objjjjj"+obj_new);
				 setTimeout(obj_new.getData(),1000);
			
		}
	}
}

function update_page(response,responseXML) {
        //	console.log(xhr.responseText);
        //	console.log(xhr.getAllResponseHeaders());

	var d = new Date();
	var months = ["January","February","March","April","May","June","July","August","September","October","November","December"];
	//var current_month = months[d.getMonth()];
	var current_month = d.getMonth();
	console.log("Current month is :",d.getMonth()+1);

	var d = new Date();
	var current_date = d.getDate();
    var parent_div = document.createElement("div");
	var p = document.createElement("p");
	p.textContent = response.toUpperCase();
	p.style.marginTop = "30px";
	//obj.divinner.appendChild(p);
	parent_div.appendChild(p);

	var hr = document.createElement("hr");
	hr.style.border = '1px solid black';
	//obj.divinner.appendChild(hr);
	parent_div.appendChild(hr);

//	var root = XMLHttpRequest.responseXML.documentElement;
	var root = responseXML.documentElement;
	console.log(root);
	
	item = root.getElementsByTagName("item");



	for(var i = 0;i<item.length;i++)
	{
		title = item[i].getElementsByTagName("title")[0];
		link = item[i].getElementsByTagName("link")[0];

		pubDate = item[i].getElementsByTagName("pubDate")[0].firstChild.nodeValue;;
		console.log("Published date is :",pubDate);

		var d = new Date(pubDate);
		var months = ["January","February","March","April","May","June","July","August","September","October","November","December"];
		//var temp_month = months[d.getMonth()];
		var temp_month = d.getMonth();

		var d = new Date(pubDate);
		var temp_date = d.getDate();

		if(current_month > temp_month)
		{
			//news is outdated
		}
		else if(current_month < temp_month)
		{
			//show news now
			anchor = document.createElement("a");
			anchor.innerHTML = title.firstChild.nodeValue;
			anchor.href = link.firstChild.nodeValue;
			anchor.target = "_blank";

			//obj.divinner.appendChild(anchor);
				parent_div.appendChild(anchor);
				var br = document.createElement('br');
			//obj.divinner.appendChild(br);
				parent_div.appendChild(br);

		}
		else
		{
			//check date
			if(current_date > temp_date)
			{
				//news is outdated
			}
			else
			{
				//show news now
				anchor = document.createElement("a");
				anchor.innerHTML = title.firstChild.nodeValue;
				anchor.href = link.firstChild.nodeValue;
				anchor.target = "_blank";

				//obj.divinner.appendChild(anchor);
				parent_div.appendChild(anchor);
				var br = document.createElement('br');
				//obj.divinner.appendChild(br);
				parent_div.appendChild(br);
				
			}
		}
	}
	obj.divinner.appendChild(parent_div);
}



function get_rss(response)
{
	console.log(response);
	
		var data = [response];
		var myJSON = JSON.stringify(data);
		console.log("Data to be sent is: ",myJSON);

		var xhr = new XMLHttpRequest();
		xhr.onreadystatechange = function()
		{
			if(xhr.readyState == 4 && xhr.status == 200)
			{
				update_page(response,xhr.responseXML);
			}
		};
		xhr.open("POST", "http://localhost:5500/get_xml", true);
		xhr.setRequestHeader("Content-Type","application/json");
		xhr.send(myJSON);

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