import sqlite3

# Connect to the database (or create it if it doesn't exist)
conn = sqlite3.connect('data.db')
cursor = conn.cursor()

cursor.execute('''
CREATE TABLE IF NOT EXISTS Player (
    ID INTEGER PRIMARY KEY AUTOINCREMENT,
    Name TEXT NOT NULL
)
''')

cursor.execute('''
CREATE TABLE IF NOT EXISTS Match (
    ID_Player1 INTEGER,
    ID_Player2 INTEGER,
    Win_ID_Player INTEGER,
    FOREIGN KEY(ID_Player1) REFERENCES Player(ID),
    FOREIGN KEY(ID_Player2) REFERENCES Player(ID),
    FOREIGN KEY(Win_ID_Player) REFERENCES Player(ID)
)
''')

# Pseudo des bots
players = [('Alice',), ('Bob',), ('Charlie',)]
cursor.executemany('INSERT INTO Player (Name) VALUES (?)', players)
