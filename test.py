#!flask/bin/python

from flask import Flask, jsonify,abort,make_response,request,session,send_file,send_from_directory,Response
import csv,time,hashlib,re,requests,datetime,os
from flask_cors import CORS,cross_origin
import hashlib
import base64

import sqlite3

offset = 4
limit = 3
userid = 0

application = Flask(__name__)
application.config['SECRET_KEY'] = 'super secret key'
CORS(application)

@application.route('/sign_in',methods=['GET','POST'])
def sign_in():
    global userid
    print("######################################################################")
    print("Sign in")
    #print(request.is_json)
    #print(request.json)
    print(request.get_json())
    body = request.get_json()
#    print(body['name'])
    hashedPassword = hashlib.sha256(body['password'].encode())
    hashedPassword = hashedPassword.hexdigest()
    #print("Hashed password is ",hashedPassword) 
    conn = sqlite3.connect('WT.db')
    command = "SELECT * FROM USERS WHERE NAME=='"+body['name']+"' AND PASSWORD=='"+hashedPassword+"';"
    #print(command)
    count = 0
    cursor = conn.execute(command)
    for row in cursor:
        user_id = row[0]
        name = row[1]
        phone = row[3]
        email = row[4]
        visits = row[5]
        balance = row[6]
        print(row)
        count = count + 1
    conn.close()
    if(count == 1):
        session['user_id'] = user_id
        session['name'] = name
        session['phone'] = phone
        session['email'] = email
        session['visits'] = visits
        session['balance'] = balance
        userid = session['user_id']
        print("Correct")
        print("user id is ",session['user_id'])
        return "1"
    else:
        print("Incorrect")
        return "-1"

@application.route('/sign_out',methods=['GET','POST'])
def sign_out():
	session.pop('user_id', None) 
	session.pop('name', None) 
	session.pop('phone', None) 
	session.pop('email', None) 
	session.pop('visits', None) 
	session.pop('balance', None) 
	return "1"

@application.route('/load_tickets',methods=['GET','POST'])
def load_tickets():
	global offset
	global limit
	offset = 4
	limit = 3
	print("######################################################################")
	print("Load Tickets")
	print(request.is_json)
	print(request.json)
	print(request.get_json())
	body = request.get_json()
	#print(body['count'])
	conn = sqlite3.connect('WT.db')
	command = "SELECT * FROM FLIGHT LIMIT 4;"
	cursor = conn.execute(command)
	response = dict()
	count = 0
	for row in cursor:
		temp_list = []
		for i in row:
			temp_list.append(i)
		print("Temp list is : ",temp_list)
		response[count] = temp_list
		count = count + 1
	print("Response to be returned is : ",response)
	print(jsonify(response))
	return jsonify(response)

@application.route('/load_more_tickets',methods=['GET'])
def load_more_tickets():
	global offset
	global limit
	print("Load MORE Tickets")
	conn = sqlite3.connect('WT.db')
	command = "SELECT * FROM FLIGHT LIMIT "+str(offset)+","+str(limit)+";"
	print(command)
	cursor = conn.execute(command)
	response = dict()
	count = 0
	for row in cursor:
		temp_list = []
		for i in row:
			temp_list.append(i)
		print("Temp list is : ",temp_list)
		response[count] = temp_list
		count = count + 1
	print("Response to be returned is : ",response)
	print(jsonify(response))
	offset = offset + limit
	return jsonify(response)

@application.route('/load_images1',methods=['GET','POST'])
def load_images():
    print("Will send image")
    image = open('bombay.jpg', 'rb')
    image_read = image.read()
    image_64_encode = base64.encodestring(image_read).decode('ASCII')
    #print("Base 64 version is : ",image_64_encode)
    #return send_file('bombay.jpg',mimetype = 'image/jpg')
    data = dict()
    data["image"] = image_64_encode
#	return jsonify(data)
    return data

@application.route('/get_filters3',methods=['GET'])
def get_filters():
	path = os.getcwd()+'/static'
	print(path)
	print(send_from_directory(path,'filters.js'))
	return send_from_directory(path,'filters.js')
	#return "1"

@application.route('/get_css',methods=['GET'])
def get_css():
	path = os.getcwd()+'/static'
	print(path)
	print(send_from_directory(path,'style.css'))
	return send_from_directory(path,'style.css')

@application.route('/check_validity',methods=['POST'])
def check_validity():
    print(request.is_json)
    print(request.json)
    print(request.get_json())
    #print(request.json.get('email'))
    if(request.json.get('name') != None):
        conn = sqlite3.connect('WT.db')
        command = "SELECT NAME FROM USERS;"
        cursor = conn.execute(command)
        names = []
        for row in cursor:
            names.append(row[0])
        print(names)
        if(request.json.get('name') in names):
            #print("present in the array")
            response = dict()
            response['name'] = -1
            return jsonify(response)
        else:
            response = dict()
            response['name'] = 1
            return jsonify(response)
    elif(request.json.get('phone') != None):
        conn = sqlite3.connect('WT.db')
        command = "SELECT PHONE FROM USERS;"
        cursor = conn.execute(command)
        phones = []
        for row in cursor:
            phones.append(row[0])
        print(phones)
        if(request.json.get('phone') in phones):
            #print("present in the array")
            response = dict()
            response['phone'] = -1
            return jsonify(response)
        else:
            response = dict()
            response['phone'] = 1
            return jsonify(response)
    elif(request.json.get('name_sign') != None):
        conn = sqlite3.connect('WT.db')
        command = "SELECT NAME FROM USERS;"
        cursor = conn.execute(command)
        names = []
        for row in cursor:
            if(request.json.get('name_sign') in row[0]):
                names.append(row[0])
        return jsonify(names)
    return "1"

@application.route('/load_box',methods=['POST'])
def load_box():
	if('Add-ons' in request.json):
		path = os.getcwd()+'/static'
		print(path)
		print(send_from_directory(path,'addons.js'))
		return send_from_directory(path,'addons.js')
	elif('Payment' in request.json):
		path = os.getcwd()+'/static'
		print(path)
		print(send_from_directory(path,'payment.js'))
		return send_from_directory(path,'payment.js')

@application.route('/make_booking',methods=['POST'])
def make_booking():
	global userid
	print(request.get_json())
	########################################
	########################################
	conn = sqlite3.connect('WT.db')
	command = "SELECT BALANCE,VISITS FROM USERS WHERE USER_ID=="+str(userid)+";";
	print(command)
	cursor = conn.execute(command)
	balance = 0
	visits = 0
	for row in cursor:
		print(row)
		balance = int(row[0])
		visits = int(row[1])
	print("Balance is :",balance)
	print("Visits is :",visits)
	discount = 0
	percent = 0
	hotel_cost = int(request.json.get('cost'))
    #print(hotel_cost)
	print("Cost is :",hotel_cost)
	if(visits <= 5):
		percent = 0.00
		discount = 0
	elif(visits > 5 and visits < 15):
		percent = 0.20
		discount = 0.2 * hotel_cost
	elif(visits >= 15 and visits < 25):
		percent = 0.30;
		discount = 0.3 * hotel_cost;
	elif(visits >= 25):
		percent = 0.35;
		discount = 0.35 * hotel_cost;
	hotel_cost = hotel_cost - discount;
	print("Discount is :",discount)
	print("Percent is :",percent)
	if(balance < hotel_cost):
		return "Less balance"
	else:
		command = "UPDATE USERS SET VISITS="+str(visits+1)+" WHERE USER_ID="+str(userid)+";";
		cursor = conn.execute(command)
		conn.commit()
		session['visits'] = int(visits+1)
		command = "UPDATE USERS SET BALANCE="+str(balance-hotel_cost)+" WHERE USER_ID="+str(userid)+";";
		cursor = conn.execute(command)
		conn.commit()
		session['balance'] = int(balance-hotel_cost)
		command = "INSERT INTO BOOKS(USER_ID,FLIGHT_ID,PAID,PASSENGER,ADDONS,DISCOUNT) VALUES ("+str(userid)+","+request.json.get('flightid')+","+str(hotel_cost)+",'"+request.json.get('fullname')+"','"+request.json.get('addons')+"',"+str(discount)+");"
		print(command)
		cursor = conn.execute(command)
		conn.commit()
	conn.close()
	########################################
	########################################
	#conn = sqlite3.connect('WT.db')
	#print("User id is",userid)
	#command = "INSERT INTO BOOKS(USER_ID,FLIGHT_ID,PAID,PASSENGER,ADDONS) VALUES ("+str(userid)+","+request.json.get('flightid')+","+request.json.get('cost')+",'"+request.json.get('fullname')+"','"+request.json.get('addons')+"');"
	#print(command)
	#cursor = conn.execute(command)
	#conn.commit()
	#conn.close()
	return str(percent*100)

@application.route('/tester',methods=['GET','POST'])
def tester():
	########################################
	########################################
	global userid
	conn = sqlite3.connect('WT.db')
	command = "SELECT BALANCE,VISITS FROM USERS WHERE USER_ID=="+str(userid)+";";
	print(command)
	cursor = conn.execute(command)
	balance = 0
	visits = 0
	for row in cursor:
		print(row)
		balance = int(row[0])
		visits = int(row[1])
	print("Balance is :",balance)
	print("Visits is :",visits)
	discount = 0
	percent = 0
	hotel_cost = request.json.get('cost')
	print("Cost is :",hotel_cost)
	if(visits <= 5):
		percent = 0.00
		discount = 0
	elif(visits > 5 and visits < 15):
		percent = 0.20
		discount = 0.2 * hotel_cost
	elif(visits >= 15 and visits < 25):
		percent = 0.30;
		discount = 0.3 * hotel_cost;
	elif(visits >= 25):
		percent = 0.35;
		discount = 0.35 * hotel_cost;
	hotel_cost = hotel_cost - discount;
	print("Discount is :",discount)
	print("Percent is :",percent)
	if(balance < hotel_cost):
		return "Less balance"
	else:
		command = "UPDATE USERS SET VISITS="+str(visits+1)+" WHERE USER_ID="+str(userid)+";";
		cursor = conn.execute(command)
		conn.commit()
		session['visits'] = int(visits+1)

		command = "UPDATE USERS SET BALANCE="+str(balance-hotel_cost)+" WHERE USER_ID="+str(userid)+";";
		cursor = conn.execute(command)
		conn.commit()
		session['balance'] = int(balance-hotel_cost)

		command = "INSERT INTO BOOKS(USER_ID,FLIGHT_ID,PAID,PASSENGER,ADDONS,DISCOUNT) VALUES ("+str(userid)+","+request.json.get('flightid')+","+str(hotel_cost)+",'"+request.json.get('fullname')+"','"+request.json.get('addons')+"',"+str(discount)+");"
		print(command)
		cursor = conn.execute(command)
		conn.commit()
	conn.close()
	########################################
	########################################
	return "1"

@application.route('/load_history',methods=['GET'])
def load_history():
	global userid
	conn = sqlite3.connect('WT.db')
	print("User id is",userid)
	command = "SELECT * FROM BOOKS WHERE USER_ID=="+str(userid);
	print(command)
	cursor = conn.execute(command)
	count = 0
	response = dict()
	#[flight_id,flight_name,paid,passenger,addons]
	for row in cursor:
		print(row)
		temp_list = []
		temp_list.append(row[1])
		command2 = "SELECT * FROM FLIGHT WHERE FLIGHT_ID=="+str(row[1])
		print(command2)
		cursor2 = conn.execute(command2)
		from_city = ""
		to_city = ""
		for row2 in cursor2:
			print(row2)
			from_city = row2[1]
			to_city = row2[2]
		temp_list.append(from_city+"-"+to_city)
		#########################333
		temp_list.append(row[5])
		temp_list.append(row[6])
		temp_list.append(row[7])
		response[count] = temp_list
		count = count + 1
	print(response)
	return jsonify(response)

@application.route('/subscribe',methods=['POST'])
def subscribe():
	global userid
	conn = sqlite3.connect('WT.db')	
	command = "DELETE FROM SUBSCRIBE WHERE USER_ID=="+str(userid)+";";
	cursor = conn.execute(command)
	for i in request.get_json():
		command = "INSERT INTO SUBSCRIBE VALUES("+str(userid)+",'"+i+"');";
		print(command)
		cursor = conn.execute(command)
		conn.commit()
	conn.close()
	return "1"

@application.route('/get_rss',methods=['GET'])
def get_rss():
	global userid
	conn = sqlite3.connect('WT.db')	
	command = "SELECT * FROM SUBSCRIBE WHERE USER_ID=="+str(userid)+";";
	print(command)
	cursor = conn.execute(command)
	airlines = []
	for row in cursor:
		airlines.append(row[1])
	print(airlines)
	#if("indigo" in airlines):
	#	return get_indigo()
	#if():
	return jsonify(airlines)

def get_document(file):
	path = os.getcwd()
	return send_from_directory(path,file,mimetype='text/xml')

@application.route('/get_xml',methods=['POST'])
def get_xml():
	print("in get xml")
	print(request.is_json)
	print(request.get_json())
	if("indigo" in request.json):
		return get_document('indigo.rss')
		#return get_document('news-releases.rss')
	if("jet_airways" in request.json):
		return get_document('jet_airways.rss')
		#return get_document('sec-filings.rss')
		#return get_document('new_jet.rss')
	if("air_india" in request.json):
		return get_document('air_india.rss')
		#return get_document('events.rss')
	return "1"

if __name__ == '__main__':
	application.run(debug=True,host="0.0.0.0",port=5500)