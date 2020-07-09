import sys
import pymysql


connection = pymysql.connect(host="localhost",user="root",passwd="omar",database="project" )
cursor = connection.cursor()


name = sys.argv[1]
ip=sys.argv[2]
prev_name=sys.argv[3]


#Sending to the database Project

query1="""UPDATE servers SET name=%s, ip=%s WHERE name=%s"""
query1_tuple=(name,ip,prev_name)
cursor.execute(query1,query1_tuple)
connection.commit()
query2="""UPDATE users SET srv=%s WHERE srv=%s"""
query2_tuple=(name,prev_name)
cursor.execute(query2,query2_tuple)
connection.commit()
connection.close()
