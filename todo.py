from sqlalchemy.ext.declarative import declarative_base
from sqlalchemy import Column, Integer, String, Float, ForeignKey, MetaData
from sqlalchemy.orm import relationship

Base = declarative_base()

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

meta = Base.metadata
