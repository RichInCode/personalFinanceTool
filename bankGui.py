from tkinter import *

class bankDisplay:

    def __init__(self):

        ##  setting up the main window
        self.main = Tk()
        
        self.main.wm_title("Transaction Entry Menu")

        self.columnLabel1 = Label(self.main, text="Please Select One").grid(row=00,column=0)
        self.columnLabel2 = Label(self.main, text="Please Select One").grid(row=00,column=1)
        self.columnLabel3 = Label(self.main, text="Please Enter Value").grid(row=00,column=2)
        
        #########################################
        ##  the transaction type boxes
        self.labelsLeft = ("Pay Bill", "Gas", "Child Care", "Food/Supplies","For Fun", "Other", "Got Paid")

        self.labelsRight = ("Melissa","Rich")

        self.framesLeft = []
        self.framesRight = []
        self.checkRorM = []

        self.avalue = StringVar()
        self.avalue.set("Pay Bill")

        self.index = 1

        for mode in self.labelsLeft[:-1]:
            
            self.acheckbutton = Radiobutton(self.main,text=mode, fg="red", variable=self.avalue, value=mode).grid(row=self.index, column=0, columnspan=1)
  
            self.framesLeft.append(self.acheckbutton)
            #self.framesLeft[i].pack(side=TOP)
            self.index = self.index+1
        

        self.framesLeft.append(Radiobutton(self.main,text=self.labelsLeft[6], fg="black", variable=self.avalue, value=self.labelsLeft[6]).grid(row=7,column=0, columnspan=1))
        ################################################



        ##########################################
        ## the Rich/Melissa Option
        self.checkRorM = StringVar()
        self.checkRorM.set("Melissa")

        for i in range(0,2):
            self.acheckbutton = Radiobutton(self.main,text=self.labelsRight[i], variable=self.checkRorM, value=self.labelsRight[i], width=20).grid(row=i+1, column=1)
            self.framesRight.append(self.acheckbutton)
        ##############################################333




        ##############################################33
        ## entry slot for transaction amount
        self.amount = StringVar()
        self.amount.set(0)
        self.amountFrame = Frame(self.main)
        self.amountLabel = Label(self.amountFrame,text="Value")
        self.amountEntry = Entry(self.amountFrame, bd=5)
        
        self.amountFrame.grid(row=1, column=2)
        self.amountLabel.grid(row=1, column=3)
        self.amountEntry.grid(row=1, column=4)
        ####################################################


        ####################################################3
        ## submit button
        self.enterButton = Button(self.main, text="Enter Transaction", command=self.submitbutton, height=5, width=20, bg="green",fg="white").grid(row=6, column=1, rowspan=1, columnspan=2)
        ###################################################33


    def submitbutton(self):
        #print self.main.amountEntry.get()
        print(self.amountEntry.get())
        print(self.avalue.get())
        print(self.checkRorM.get())
        #str astring = self.avalue.get()
        #print self.avalue[:]
        #print astring

    def run(self):
        self.main.mainloop()
