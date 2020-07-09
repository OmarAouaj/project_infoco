from netmiko import ConnectHandler
import sys
import pymysql


connection = pymysql.connect(host="localhost",user="infoco",passwd="infoco",database="project" )
cursor = connection.cursor()


argList = sys.argv
name = argList[1]
user = argList[2]
username = argList[3]
pwd = argList[4]
grp=argList[5]

q="""SELECT u.username FROM users u JOIN servers s ON u.srv=s.name WHERE s.name like %s AND u.username LIKE %s"""
q_tuple=(name,user)
cursor.execute(q,q_tuple)
if len(cursor.fetchall())!=0:
	print("exists")
else:

	query="""SELECT s.ip FROM servers s JOIN users u ON u.srv=s.name WHERE s.name like %s"""
	query_tuple=(name)
	cursor.execute(query,query_tuple)

	data=cursor.fetchone()
	ip=data[0]


	myssh=ConnectHandler(device_type="linux",host=ip,username=username,password=pwd)
	q1="""SELECT grp FROM users WHERE grp LIKE %s"""
	q1_tuple=(grp)

	cursor.execute(q1,q1_tuple)
	if len(cursor.fetchall())!=0:
		myssh.find_prompt()
		myssh.send_command("useradd "+user+" -g "+grp)
	else:
		myssh.find_prompt()
		myssh.send_command("groupadd "+grp)
		myssh.send_command("useradd "+user+" -g "+grp)


	query1="""INSERT INTO users(username,srv,grp) VALUES(%s,%s,%s)"""
	query1_tuple=(user,name,grp)
	cursor.execute(query1,query1_tuple)
	connection.commit()
	connection.close()

	print("ok")
#Sending to the database Project