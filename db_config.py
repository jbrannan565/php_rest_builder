from sqlalchemy import create_engine
import json
import os

class DB:
    def __init__(self):
        with open("config.json", "r") as cf:
            config = json.loads("".join(cf.readlines()))
            user = config['user']
            password = config['password']
            host = config['host']
            database = config['database']

            self.create_database_engine(user, password, host, database)
            self.build_dbclass(host, user, password, database)

    def create_database_engine(self, user, password, host, database):
        self.engine = create_engine("mysql+pymysql://{}:{}@{}/{}".format(
                user, password, host, database
                ), echo=True)
        print("database engine created")

    def build_dbclass(self, host, user, password, database):
        os.mkdir("output/config")
        with open("templates/config/dbclass.php", "r") as f:
            create_template = "".join(f.readlines()) % (
                    str(host),
                    str(user),
                    str(password),
                    str(database)
                    )
            with open("output/config/dbclass.php", "w+") as o:
                o.write(create_template)
                print("config/dbclass.php created")
            

os.system("rm -r output/*")
db = DB()
