from netmiko import ConnectHandler
import sys
import pymysql


connection = pymysql.connect(host="localhost",user="infoco",passwd="infoco",database="project")
cursor = connection.cursor()


argList = sys.argv

name = argList[1]
ip = argList[2]
user = argList[3]
pwd = argList[4]
state= argList[5]

myssh=ConnectHandler(device_type="linux",host=ip,username=user,password=pwd)
myssh.find_prompt()
mac=myssh.send_command("cat /sys/class/net/e*/address")
os=myssh.send_command("cat /etc/*release* | head -1")
ts=myssh.send_command("df -h --output=size --total | awk 'END { print $1 }'")
avs=myssh.send_command("df -h --output=avail --total | awk 'END { print $1 }'")
tr=myssh.send_command("free -ht | tail -1 | awk 'END { print $2 }'")
avr=myssh.send_command("free -ht | tail -1 | awk 'END { print $4 }'")


#adding the users
users=myssh.send_command("cat /etc/passwd | grep 'sh$' | cut -d':' -f1")
liste=list(users.split("\n"))
for x in liste:
	gid=myssh.send_command("cat /etc/passwd | grep '^{}' | cut -d':' -f4".format(x))
	group=myssh.send_command("cat /etc/group | grep ':{}:' | cut -d':' -f1".format(gid))
	query1="""INSERT INTO users(username,srv,grp) VALUES(%s,%s,%s)"""
	query1_tuple=(x,name,group)
	cursor.execute(query1,query1_tuple)
	connection.commit()

#Sending to the database Project

query="""INSERT INTO servers(name,mac,ip,os,totalstorage,availstorage,totalram,availram,State) VALUES(%s,%s,%s,%s,%s,%s,%s,%s,%s)"""
query_tuple=(name,mac,ip,os,ts,avs,tr,avr,state)

cursor.execute(query,query_tuple)
connection.commit()
connection.close()
print("ok")