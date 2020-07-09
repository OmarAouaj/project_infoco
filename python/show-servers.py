import pymysql

connection = pymysql.connect(host="localhost",user="infoco",passwd="infoco",database="project" )
cursor = connection.cursor()

query="""SELECT s.name,s.ip,s.mac,s.os,s.totalstorage,s.availstorage,s.totalram,s.availram,GROUP_CONCAT(u.username) usernames FROM servers s JOIN users u ON (s.name = u.srv) GROUP BY s.name"""
cursor.execute(query)

data=cursor.fetchall()
print(data)
