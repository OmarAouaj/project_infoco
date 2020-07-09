from netmiko import ConnectHandler
import sys
import pymysql
import re
import json


connection = pymysql.connect(host="localhost",user="infoco",passwd="infoco",database="project")
cursor = connection.cursor()
query="""SELECT s.ip,s.name FROM servers s JOIN users u ON u.srv=s.name WHERE u.username LIKE %s"""
query_tuple=(sys.argv[1])
cursor.execute(query,query_tuple)
data=cursor.fetchone()
ip=data[0]
name=data[1]
argList=sys.argv
username=argList[1]
user= argList[2]
pwd = argList[3]


myssh=ConnectHandler(device_type="linux",host=ip,username=user,password=pwd)
myssh.find_prompt()
liste=list()
history=myssh.send_command("last "+username)
i=0
l=0
while i<len(history)-l:
	s=""
	while history[i]!="\n":
		s+=history[i]
		i+=1
	l=len(s)
	i+=1
	liste.append(s)

for x in liste:
	query="""INSERT INTO history(server,history) VALUES(%s,%s)"""
	query_tuple=(name,x)
	cursor.execute(query,query_tuple)
	connection.commit()

connection.close()




