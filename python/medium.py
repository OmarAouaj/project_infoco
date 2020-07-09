import sys
import pymysql
import json

connection = pymysql.connect(host="localhost",user="infoco",passwd="infoco",database="project" )
cursor = connection.cursor()

query="""SELECT name,ip FROM servers WHERE name=%s"""
query_tuple=(sys.argv[1])
cursor.execute(query,query_tuple)

data=cursor.fetchone()
liste=list(data)
d={'name': liste[0], 'ip': liste[1]}
print(json.dumps(d))
connection.close()