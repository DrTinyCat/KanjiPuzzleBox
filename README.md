# KanjiPuzzleBox
A CSV of kanji is converted into an interactive Web puzzle

-depends on Python modules 
> pathlib, 
> io, 
> pandas, 
> numpy, 

-depends on '<same directory>/Target/squaregameheader.csv'
    
-receives csv in the format "Kanji", "Pronunciation", "Meaning", "Place1",..."Place9"
-returns html just showing Kanji and their puzzlebox numbers
    
-still needed: kanji must be formatted to 13 (wide) by 14 (high) grid. 


## To properly install: 
1. download squaregame.py
2. download "squaregameheader.csv"
  *set Path(...) in line 28 to the path of squaregameheader.csv on your computer
3. run squaregame.py
4. in same directory PuzzleBox.html will appear
5. open PuzzleBox.html in browser
