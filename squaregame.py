from pathlib import Path
import io
import pandas as pd
import numpy as np

def MakeColumnList(df):
    listColumn = []
    for each in df.columns:
        listColumn = listColumn + [each]
    return listColumn
### RETURNS easily iterable LIST of the names controlling the columns of the DATAFRAME
#

def Rename(kanji, place, df):
    data = df[[kanji,place]]
    new = data.rename(columns={kanji: "Kanji", place:"PuzzleBox"})
    return new
### kanji must be a STRING from the listColumn list
### place must be a STRING from the listColumn list
### RETURNS a DATAFRAME with two renamed columns
#

#
#main program#
#
# stack the last 9 columns of a dataframe into 1 column  

pathObject = Path('c:/users/admin/remotevim/target/squaregameheader.csv')
csvFile = pd.read_csv(pathObject)
# open kanji/pronunciation/meaning/occurence list as DATAFRAME object
# DATAFRAME has 30 rows and 12 columns

plist = MakeColumnList(csvFile)
# make a list of the columns, 'Kanji', 'Pronunciation',...etc

globalList = []
for item in plist: 
    if plist.index(item) >2:
        li = Rename("Kanji", item, csvFile)
        globalList = globalList + [li]
#li is a DATAFRAME of 2 columns
#li will be rewritten in the next iteration
#global stores the result before the next iteration

result = pd.concat(globalList, ignore_index=True)
#concatenate all the dataframes together
#this is unsorted
#this is full of duplicates
#Kanji is object, PuzzleBox is int64

best = result.sort_values(by=["PuzzleBox"]).drop_duplicates(subset=["PuzzleBox"]).set_index("PuzzleBox").drop(999)
#sorted by PuzzleBox
#dropped duplicates
#set PuzzlBox as index
#dropped filler index "999"

html = best.to_html(col_space="10px", show_dimensions=True)
#render as HTML string

text_file = open("PuzzleBox.html", "w", encoding="utf-8")
text_file.write(html)
text_file.close()
#create, write, and close .HTML text file