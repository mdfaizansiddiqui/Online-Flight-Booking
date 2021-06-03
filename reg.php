<html>
	<head>
	</head>
	<body id='body'>
	
	<!--script-->
			<?php
				extract($_POST);
        
        
//                $db=new PDO('sqlite3: WT.db');
        
//            $db = new PDO('sqlite:WT.db', '', '', array(
//            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
//            ));

//			   class MyDB extends SQLite3 {
//			      function __construct() {
//			         $this->open('WT.db');
//			      }
//			   }   
//        
//              $db = new MyDB();
        
        
//                $db->open('WT.db');
               $db= new SQLite3("WT.db");
               
			   if(!$db){
			      echo $db->lastErrorMsg();
			   } else {
			      echo "Opened database successfully\n";
			   }

			   $sql = "";
			   //echo $RorS;
			   if($RorS==1){
					//Registration
			   		$sql = "SELECT * FROM USERS WHERE PHONE=='".$phone."' OR EMAIL=='".$email."';";
			   		$results = $db->query($sql);
			   		$count=0;
					while ($row = $results->fetchArray()) {
						$count = $count + 1;
					}
					if($count > 0)
					{
                        echo "<p>Fuck off</p>";
//                        echo "alert(fuck);";
//						echo "var p = document.createElement('p');p.textContent = '2';var body = document.getElementById('body');body.insertBefore(p,body.childNodes[0]);";
						echo "<script>console.log(parent);</script>";
					}
					else if($count==0){
						//Enter into database and send an email
					   	$hashedPassword = hash('sha256', $password);
					    $sql = "INSERT INTO USERS (NAME,PASSWORD,PHONE,EMAIL,VISITS,BALANCE) VALUES ('".$name."','".$hashedPassword."','".$phone."','".$email."',0,15000);";

					    $ret = $db->exec($sql);
					   if(!$ret) {
					      echo $db->lastErrorMsg();
					   }
					   else {
                            //after executing sql and inserting data in db , shows registration successfull on webpage just below the register button.
					   		echo "<script>var p = document.createElement('p');p.textContent = '1';var body = document.getElementById('body');body.insertBefore(p,body.childNodes[0]);</script>";
							echo "<script>check_if_reg();</script>";


							//send message on phone
							//2Factor authentication

							$key = "32d2a810-ea63-11e9-b828-0200cd936042";


							$curl = curl_init();
							$key = "32d2a810-ea63-11e9-b828-0200cd936042";

							curl_setopt_array($curl, array(
							  CURLOPT_URL => "http://2factor.in/API/V1/".$key."/SMS/".$phone."/Hello",
							  //CURLOPT_RETURNTRANSFER => true,
							  //CURLOPT_ENCODING => "",
							  //CURLOPT_MAXREDIRS => 10,
							  //CURLOPT_TIMEOUT => 30,
							  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
							  CURLOPT_CUSTOMREQUEST => "GET",
							  CURLOPT_POSTFIELDS => "",
							  CURLOPT_HTTPHEADER => array(
							    "content-type: application/x-www-form-urlencoded"
							  ),
							));

							echo "//";
							$response = curl_exec($curl);
							echo ";\n";
							$err = curl_error($curl);

							curl_close($curl);
						}
					}

				}
				else if($RorS==0){
					//Sign in
					$hashedPassword = hash('sha256', $password);
					$sql = "SELECT * FROM USERS WHERE PASSWORD=='".$hashedPassword."' AND NAME=='".$name."';";

					$results = $db->query($sql);
					$row="";$phone="";$email="";

					//echo "</script><?php";
					echo "var row;";
					$count=0;
					while ($row = $results->fetchArray()) {
						echo "row = ".json_encode($row).";";
						echo "console.log(row);";
						$count = $count + 1;
						$id = $row['ID'];
						$phone=$row['PHONE'];;
						$email=$row['EMAIL'];
						$visits = $row['VISITS'];
						$balance = $row['BALANCE'];
					}

					if($count == 1)
					{
						echo "var p = document.createElement('p');p.textContent = '1';var body = document.getElementById('body');body.insertBefore(p,body.childNodes[0]);";
						echo "parent.check_if_signed()";

						//Now start setting cookies and sessions
						session_start();
						$_SESSION['user_id'] = $id;
						$_SESSION['name'] = $name;
						$_SESSION['pwd'] = $hashedPassword;
						$_SESSION['phone'] = $phone;
						$_SESSION['email'] = $email;
						$_SESSION['visits'] = $visits;
						$_SESSION['balance'] = $balance;

						//setting a cookie
						//setcookie("user",$name,time() + (86400 * 30),"/");

						//echo "console.log('Phone no is ".$_SESSION['phone']."');";

					}
					else
					{
						//If more than 1 person exists do not allow to login
						echo "var p = document.createElement('p');p.textContent = '0';var body = document.getElementById('body');body.insertBefore(p,body.childNodes[0]);";
						echo "parent.check_if_signed()";
					}

				}

			   $db->close();
			?>
	<!--/script-->
    </body>
<html>	