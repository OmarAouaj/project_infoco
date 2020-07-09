import pymysql
import sys

connection = pymysql.connect(host="localhost",user="infoco",passwd="infoco",database="project" )
cursor = connection.cursor()

query1="""DELETE FROM servers WHERE name=%s"""
query1_tuple=(sys.argv[1])
cursor.execute(query1,query1_tuple)
connection.commit()
query2="""DELETE FROM users WHERE srv=%s"""
query2_tuple=(sys.argv[1])
cursor.execute(query2,query2_tuple)
connection.commit()
connection.close()