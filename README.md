Description:
A tool to automatically generate php scripts for a crud/rest api.

Usage:
1. Edit config.json to include the user, password, host, and database for the project.

2. Edit setup.py, writing data models as sqlalchemy.Base classes.
	EXAMPLES:
	    class Todo(Base):
		__tablename__ = "todo"
		id = Column(Integer, primary_key=True)
		percent_done = Column(Float)
		text = Column(String(255))

		category_id = Column(Integer, ForeignKey("category.id"))
		category = relationship("Category", foreign_keys=[category_id])

	    class Category(Base):
		__tablename__ = "category"
		id = Column(Integer, primary_key=True)
		name = Column(String(100))

3. Delete all contents of ./output directroy.

4. run python build.py

Output:
All output files will be found in the ./output directory.
