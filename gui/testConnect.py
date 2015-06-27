#! /usr/bin/python

import pymysql

conn = pymysql.connect(host='localhost', port=3306, user='root', passwd='', db='householdfinance')

cur = conn.cursor()

cur.execute("select trans_id from billpay;");
#cur.execute("describe billpay;")

for r in cur.fetchall():
    print(r)

cur.close()
conn.close()
