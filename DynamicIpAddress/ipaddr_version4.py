import tkinter as tk
import socket
import requests,time,os, sys
from datetime import datetime, timedelta
from PIL import Image, ImageTk
import json

class IPAddress:
    def __init__(self, root):
        self.root = root
        self.root.title("FindIPAddress")
        self.root.geometry("500x200")
        self.time_remaining = tk.StringVar()
        self.ip_address = tk.StringVar()
        self.ip_public = tk.StringVar()
        self.ip_public_bt = tk.StringVar()
        self.start_time = None
        self.end_time = None
        self.running = False
        self.previous_public_ip = None
        self.initial_check = False
        self.current_time = tk.StringVar()
        self.current_time_label = tk.Label(root, textvariable=self.current_time, font=("Arial", 10))
        self.current_time_label.place(relx=0.05, rely=0.95, anchor='w')


        self.user_name = None
        self.password = None


        self.check_update = False
        self.menu_bar() #creating menu bar
    

         # Create a frame for the buttons
        button_frame = tk.Frame(root)
        button_frame.pack(anchor='nw')

        #image
        try:
            self.image = Image.open(self.resource_path("Images/ip_icon_v4.png"))
            self.image = self.image.resize((100, 100))  
            self.photo = ImageTk.PhotoImage(self.image)
            image_label = tk.Label(root, image=self.photo)
            image_label.place(relx=0.03, rely=0.45, anchor='w')

        except FileNotFoundError:
            print("Error: Image file not found.")
        except Exception as e:
            print("An error occurred:", str(e))
        # bottom frame
        self.bottom_frame(root)
    
        #text at the center                
        self.text_center(root)

        # self.update_successful(root)
       
        #newtab
        self.dns_button = tk.Button(root, text="DNS", width=10, command=self.open_dns_window)
        self.dns_button.place(relx=0.75, rely=0.2, anchor='w')

        #Refreshbutton
        self.start_button = tk.Button(root, text="Refresh Now", width=10, command=self.check_public_ip)
        self.start_button.place(relx=0.75, rely=0.4, anchor='w')
        button = tk.Button(root, text='Stop', width=10, bg='red', command=root.destroy)
        button.place(relx=0.75, rely=0.6, anchor='w') 

        self.status_label = tk.Label(root, text="", font=("Arial", 8))
        self.status_label.place(relx=0.32, rely=0.58, anchor='center') 

        # self.update_time()
        self.display_ip_address()
        self.display_public_ip()
        self.display_public_ip_bt()
        self.check_public_ip()

        self.start()  # Start the timer as soon as the program runs

    def resource_path(self, relative_path):
        #Get absolute path to resource, works for dev and for Pyinstaller
        try:
            #Pyinstaller creates a temp folder and stores path in _MEIPASS
            base_path = sys._MEIPASS
        except Exception:
            base_path = os.path.abspath(".")
        return os.path.join(base_path,relative_path)
    
    def menu_bar(self):
        # Create the menu bar
        menu_bar = tk.Menu(self.root)
        menu_bar.configure(bg='white')

        def on_enter(event): #not working
            menu_bar.config(bg="blue")

        def on_leave(event): #not working
            menu_bar.config(bg="white")

    # Bind the events to the menu bar
        menu_bar.bind("<Enter>", on_enter) #not working
        menu_bar.bind("<Leave>", on_leave) #not working

        # Create the File menu
        file_menu = tk.Menu(menu_bar, tearoff=0)
        file_menu.add_command(label="Preference")
        file_menu.add_command(label="Hide")
        file_menu.add_separator()
        file_menu.add_command(label="Exit", command=self.root.destroy)

        # Add the File menu to the menu bar
        menu_bar.add_cascade(label="File", menu=file_menu)

        # Create the Edit, Tools, and Help menus
        edit_menu = tk.Menu(menu_bar, tearoff=0)
        edit_menu.add_command(label="copy IP address")
        edit_menu.add_command(label="copy Client ID")

        tools_menu = tk.Menu(menu_bar, tearoff=0)
        tools_menu.add_command(label="Purchase Plus")
        tools_menu.add_command(label="Manage Hosts")
        tools_menu.add_command(label="IPaddr Home")
        tools_menu.add_command(label="Open Port Check Tool")
        tools_menu.add_command(label="Domain Registration Search")
        tools_menu.add_command(label="Flush Local DNS")
        tools_menu.add_separator()
        tools_menu.add_command(label="logs")

        help_menu = tk.Menu(menu_bar, tearoff=0)
        help_menu.add_command(label="Forgot Password")
        help_menu.add_command(label="Sign up")
        help_menu.add_command(label="Getting Started")
        help_menu.add_command(label="Support")
        help_menu.add_separator()
        help_menu.add_command(label="Terms of Service")

        # Add the Edit, Tools, and Help menus to the menu bar
        login_menu = tk.Menu(menu_bar, tearoff=0)
        menu_bar.add_cascade(label="Edit", menu=edit_menu)
        menu_bar.add_cascade(label="Tools", menu=tools_menu)
        menu_bar.add_cascade(label="Help", menu=help_menu)
        menu_bar.add_cascade(label="Login", command=self.login)

        # Configure the menu bar
        self.root.config(menu=menu_bar)

        # Pack the menu bar to the top-left corner
        self.root.config(menu=menu_bar)
    def login(self):
        login_window = tk.Toplevel(self.root)
        login_window.title("Login")
        login_window.geometry("200x300")

        user_name = tk.Entry(login_window)
        user_name.pack(pady=30)
        password = tk.Entry(login_window)
        password.pack(pady=30)
        

        submit_button = tk.Button(login_window, text="Submit",command=lambda:self.print_loginname(login_window,user_name,password))
        submit_button.pack()
    
    def print_loginname(self,window,user_name,password):
        user_name = user_name.get()
        password = password.get()
        

        login_url = "http://192.168.62.20/myweb_origin/ip_userinfo_dns/verify_login.php"
        response = requests.get(login_url)
        
        tk.Label(window, text=f'{user_name}, Registered!', pady=20, bg='#ffbf00').pack()
        tk.Label(window, text=f'{password}, Registered!', pady=20, bg='#ffbf00').pack()


    def bottom_frame(self,root):
         # bottom frame
        frame = tk.Frame(root, height=20, bg='#F2DEDE')
        frame.pack(side='bottom', fill='x')
        
        text_label = tk.Label(frame, text=": Remote IP Found:", fg='black',bg='#F2DEDE')
        text_label.place(relx=0.22, rely=0.52, anchor='center')
            # text_label.place_forget()

        self.ip_label = tk.Label(root, textvariable=self.ip_public_bt, font=("Arial", 10),bg='#F2DEDE')
        self.ip_label.place(relx=0.42, rely=0.95, anchor='center')
            # self.ip_label.place_forget()

        self.current_time_label = tk.Label(root, textvariable=self.current_time, font=("Arial", 10),bg='#F2DEDE')
        self.current_time_label.place(relx=0.01, rely=0.95, anchor='w')

    def text_center(self,root):
        self.ip_label = tk.Label(root, textvariable=self.ip_address, font=("Arial", 10))
        self.ip_label.place(relx=0.45, rely=0.3, anchor='center')
        self.ip_label = tk.Label(root, textvariable=self.ip_public, font=("Arial", 10))
        self.ip_label.place(relx=0.465, rely=0.4, anchor='center')
        
        self.check_time = tk.Label(root, text="Next Check:", font=("Arial", 10))
        self.check_time.place(relx=0.32, rely=0.5, anchor='center')
        self.label = tk.Label(root, textvariable=self.time_remaining, font=("Arial", 10))
        self.label.place(relx=0.45, rely=0.5, anchor='center')


    def update_successful(self,root):
        frame = tk.Frame(root, height=20, bg='#F2DEDE')
        
        text_label = tk.Label(frame, text="IP Address updatead successfully", fg='Green')
        text_label.place(relx=0.22, rely=0.5, anchor='center')


    def update_current_time(self): #update the lastet check time
        current_time = time.strftime("%H:%M:%S")
        self.current_time.set(current_time)
        

    def update_time(self): #update timer 
        if self.running:
            time_left = self.end_time - datetime.now()
            if time_left.total_seconds() <= 0:
                self.running = False
                self.reset()  # Reset the timer to 3 minutes
                self.start()  # Restart the timer
                self.check_public_ip() #check ip address every 3 minutes
            else:
                time_left_str = str(time_left).split(".")[0]
                self.time_remaining.set(time_left_str)
                
        self.root.after(1000, self.update_time)

    def display_ip_address(self):
        ip_add = socket.gethostbyname(socket.gethostname())
        self.ip_address.set("Device IP Address: " + ip_add)

    def display_public_ip(self):
        response = requests.get('https://api.ipify.org?format=json')
        data = response.json()
        public_ip = data['ip']
        self.ip_public.set("My public IP address is: " + public_ip)

    def display_public_ip_bt(self):
        response = requests.get('https://api.ipify.org?format=json')
        data = response.json()
        public_ip = data['ip']
        self.ip_public_bt.set(public_ip)    

    def check_public_ip(self):
        self.display_ip_address()
        self.display_public_ip()
        self.display_public_ip_bt()
        self.replace_public_ip(self.get_first_hostname()) #update the first row in the database

        public_ip = self.ip_public_bt.get()
      
        if not self.initial_check:
            self.previous_public_ip = public_ip
            self.initial_check = True
        elif public_ip != self.previous_public_ip:
            self.previous_public_ip = public_ip
            self.status_label.config(text="Public IP changed!")
           
        else:
            self.status_label.config(text="No IP Change!")
         
        self.reset()
        self.start()
        
    def start(self):
        if not self.running:
            self.running = True
            self.start_time = datetime.now()
            self.end_time = self.start_time + timedelta(seconds=20)  # Set timer to 3 minutes (180)
            self.update_time() #to update the timer 
            self.update_current_time()#to show the lastest check time at the bottom corner
            

    def reset(self):
        self.running = False
        self.time_remaining.set("00:03:00")

    def open_dns_window(self):
        # self.update_check = False
        dns_window = tk.Toplevel(self.root)
        dns_window.title("DNS Window")
        dns_window.geometry("500x300")

  
        php_url = "http://192.168.62.20/myweb_origin/ip_userinfo_dns/db_query_add.php"
        response = requests.get(php_url)

        # Parse the JSON response
        rows = json.loads(response.text)
        self.get_data(response,rows,dns_window)

        submit_button = tk.Button(dns_window, text="Submit", command=lambda: self.submit(dns_window))
        submit_button.pack()
    
    def submit(self,window):
        selected_data = []
        for var in self.checklist_vars:
            if var.get():
                selected_data.append(var.get())
        
        self.replace_public_ip(selected_data[0])
        self.check_update = True
        
        window.destroy()


    def replace_public_ip(self, selected_data):

        response = requests.get('https://api.ipify.org?format=json')
        data = response.json()
        new_public_ip = data['ip']
        update_url = "http://192.168.62.20/myweb_origin/ip_userinfo_dns/db_query_update.php"

        try:
            response = requests.post(update_url, data={"selected_data": selected_data, "new_ip_address": new_public_ip})
            response.raise_for_status()  # Check for any HTTP errors
            
            if response.status_code == 200:
                
                print("DNS updated successfully.")
                print("New public IP address:", new_public_ip)
        except requests.exceptions.RequestException as e:
            print(f"Error occurred while updating DNS: {e}")
       
    def get_data(self,response,rows,dns_window):
        try:
            response.raise_for_status()  
            rows = response.json()  
            self.checklist_vars = []

            for row in rows:
                host_name = row.get('host_name')
                if host_name:
                    var = tk.StringVar()
                    self.checklist_vars.append(var)
                    checkbox = tk.Checkbutton(dns_window, text=host_name, variable=var, onvalue=host_name, offvalue="")
                    checkbox.pack(anchor="w")
        except Exception as e:
            error_label = tk.Label(dns_window, text="Error occurred while fetching data from the database.")
            error_label.pack()
            print(f"Error: {e}")

    def get_first_hostname(self):
        php_url = "http://192.168.62.20/myweb_origin/ip_userinfo_dns/db_query_add.php"
        response = requests.get(php_url)

        try:
            response.raise_for_status()  # Check for any HTTP errors
            rows = response.json()
            if rows:  # Checking if the rows list is not empty
                first_row = rows[0]  
                first_hostname = first_row.get('host_name')  
                return first_hostname  
            else:
                return None  
        except requests.exceptions.RequestException as e:
            print(f"Error occurred while fetching data from the database: {e}")
            return None

root = tk.Tk()
stopwatch = IPAddress(root)
root.mainloop()