# KanjiPuzzleBox
A CSV of kanji is converted into an interactive Web puzzle

## Prerequisites: 
You must OpenOffice or similar. 
You must have Notepad. 
You must have Python with pandas.

## Process: 
### 1. Save "KanjiPuzzle.py" into whichever folder you want your output HTML file to end up. 
    Save "PuzzleInput01.ods" into whichever folder is easiest, usually the same folder. 

### 2. Edit your puzzle in OpenOffice or similar. 
    - All puzzles begin in the provided ODS file. Do not alter the ODS columns or rows, only the fields. 
    - Note the full path and filename of your ODS. 
    ***tip: if you save this file in the same folder as "KanjiPuzzle.py" omit the path in the next step.*** 

### 3. Edit KanjiPuzzle.py in NotePad. 
    - On line 133, replace the first input to your full/path/filename.ods of the ODS file. 
    ***you can skip the path if the ODS file is saved in the same folder as KanjiPuzzle.py***
    ***if you must use a path, use forward / slashesas blackslashes are escape characters***
    - Replace the second input with the desired filename (no extension!). 
    - Save KanjiPuzzle.py. 

### 4. Open Command Prompt. 
    - Change directory to the folder where "KanjiPuzzle.py" is located. 
        cd /path/to/the/folder/
    - Execute KanjiPuzzle.py
        KanjiPuzzle.py or python KanjiPuzzle.py

### 5. An HTML will appear in the folder. That is your finished puzzle. Open in a browser to view. 

Still Needed: 
    Add detection of OS so that KanjiPuzzle.py can detect OS directory and place a temporary file "intermediate.csv" where it has permission. 
    Add detection of OS so that KanjiPuzzle.py dan detect OS directory and place final output to any folder a user desires. 
    After these changes, KanjiPuzzle.py can be saved in %appdata% as a module so it can be called using KanjiPuzzle.MainProgram(<ODSfile>, <outputpath/name>). The user will no longer have to manually edit KanjiPuzzle.py. 
    
