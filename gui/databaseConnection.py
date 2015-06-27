import pymysql

class databaseConnection:

    #def __init__(self, host, dbuser, passw, name, table, updateWith):
    def __init__(self):
        self.conn = pymysql.connect(host='localhost',port=3306,user='root',passwd='',db='householdfinance')

        #if(table == 'currentMoney'):
            #put in the trans. amount, who and what type
         #   print(table)
    
        #if(table == 'billPay'):
            #put in the specific bill payed
         #   print(table)

        #self.updateCurrentMoney()

        #conn.close()


    def endConnection(self):
        self.conn.close()

    def updateCurrentMoney(self, entryList):
        print('something')
        self.cur = self.conn.cursor()

        self.cur.execute("INSERT INTO current_money (id, type, person, amount, current) VALUES(" + "0," + entryList[0] + "," + entryList[1] + "," + entryList[2] + "," + "0" + ");")
   
        self.cur.close()

    
    def updateBillPay(self):
        print('placeholder')
