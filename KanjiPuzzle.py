from pathlib import Path
import pandas as pd
import io

def OpenOdsCSV(str):
    f = pd.read_csv(Path(str))
    return f
# open kanji/pronunciation/meaning/occurence list as DATAFRAME object
# DATAFRAME has 30 rows and 12 columns

def MakeColumnList(df):
    listColumn = []
    for each in df.columns:
        listColumn = listColumn + [each]
    return listColumn
# RETURNS easily iterable LIST of the strings (headings) of the DATAFRAME

def Rename(kanji, place, df):
    data = df[[kanji,place]]
    new = data.rename(columns={kanji: "Kanji", place:"PuzzleBox"})
    return new
# kanji must be a STRING from the listColumn list
# place must be a STRING from the listColumn list
# RETURNS a DATAFRAME with two renamed columns

def BuildCSV(fullpath):
    dataframe = OpenOdsCSV(fullpath)
    plist = MakeColumnList(dataframe)
    globalList = []
    for item in plist: 
        if plist.index(item) > 2:
            li = Rename("Kanji", item, dataframe)
            globalList = globalList + [li]
    result = pd.concat(globalList, ignore_index=True)
#open CSV into DATAFRAME 
#generate a list of column headings
#generate an empty globalList
#Rename() breaks up the dataframe into renamed, 2-col DFs
#concatenate all the dataframes together
#new DF is unsorted, full of duplicates

    sort = result.sort_values(by=["PuzzleBox"]).drop_duplicates(subset=["PuzzleBox"]).set_index("PuzzleBox").drop(999)

#sort by and drop duplicates in PuzzleBox
#set index and drop filler index "999"

    slice = sort["Kanji"]
#pull unidimensional array from DATAFRAME

    txt = open(("intermediate.csv"), "w", encoding="utf-8")
    j = 0
    while j < 182:
        txt.write(slice.pop(j) + ",")
        j+=1
    txt.close()
#create, write, and close CSV text file
    return None

###BuildCSV("c:/users/admin/remotevim/PuzzleBox/PuzzleInput01.csv", "intermediate")
#uncomment this for testing

def openSRC(pathstr):
    src = open(pathstr, "r", encoding="utf-8")
    fill = src.read()
    return fill
#pass in a string of the filename or path/filename
#returns a string

def convertSRC(str):
    boxCount = 0
    kArray = []
    for k in str:
        if k == ",":
            boxCount = boxCount + 1
        else:
            kArray = kArray + [k]
    return kArray
#change CSVstring into an array that python can iterate

def tableHead(file):
    file.write("<table>\n<thead><tr>")
    i = 0
    while i < 13:
        file.write("<th>" + str(i+1) + "</th>\n")
        i+=1
    file.write("</tr></thead>\n")
    return None

def tableBody(file, array):
    boxCount = 0
    file.write("<tbody>\n")
    j = 0
    while j < 14:
        k = 0
        file.write("<tr>")
        while k < 13:
            file.write("<td>" + array[boxCount] + "</td>")
            k+=1
            boxCount +=1
        file.write("</tr>\n")
        j +=1
    file.write("</tbody></table>")
    return None


def buildBox(str, array):
    box = open((str + ".html"), 'w', encoding="utf-8")
    box.write("<!DOCTYPE html>\n<html>\n<head>\n<title>Kanji Puzzle</title>\n<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />\n<style>table, th, td {border: 1px solid black;}</style>\n</head>\n<body>\n")
    tableHead(box)
    tableBody(box, array)
    box.write("</body>\n</html>")
    box.close()
    return None
#begins the HTML document
#writes the headings of the table
#writes the body of the table
#finishes the HTML document and closes file

def BuildPuzzle(output):
    buildBox(output, convertSRC(openSRC("intermediate.csv")))
    return None

#input is a string of desired filename of the output (no extension)

###BuildPuzzle("intermediate.csv", "Puzzle01")
#uncomment this for testing

def MainProgram(fullpathODS, output):
    BuildCSV(fullpathODS)
    BuildPuzzle(output)
    return None

MainProgram("PuzzleInput01.ods", "ItWorked")