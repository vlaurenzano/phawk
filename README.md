# phawk
Phawk is a simple but powerful php implementation of AWK. With phawk, you can easily digest files using the the power of php. 

# Usage
Usage of phawk is simple, there are only two operating modes.

1) Using one command. When used with one command, it will be executed for every line of the input file. 

`
cat my_file.txt | phawk 'echo $v1,$v2,"\n";'
`
You can also specify the field seperator as the last argument:

`
cat my_file.txt | phawk 'echo $v1,$v2,"\n";' ','
`


2) Using three commands; a beggining, line, and end command. When used with three commands, the first command will be executed before anything is process, the second will be executed once per line and the third will be executed after the file is digested. 

`
cat my_file.txt | phawk '$myCounter = 0;' 'echo $v0; $myCounter++;"; 'echo $myCounter, "\n;'
`

Again you can specify the field seperator as the last argument:

`
cat my_file.txt | phawk '$myCounter = 0;' 'echo $v0; $myCounter++;"; 'echo $myCounter, "\n;' ','
`


#Special Values

Phawk supplies several values to be used in your line command. 

1) $ln       -- The current 1 based line number

`
echo 'This is a line' | phawk 'echo $ln' #displays 1 
`


2) $line     -- The current line


`
echo 'This is a line' | phawk 'echo $line' #displays 'This is a line'
`

3) $v0       -- Also the current line

4) $v1..$vn  -- A local variable containing the contents of the line, seperated by a space. For example, if the line is A 1 2 3, $v1 == A, $v2 == 2, $v3 == 3;

`
echo '1 2 3' | phawk 'echo $v1, $v2' #display 12 
`

5) $display  -- Set $display to true in your command script to display the entire line. For example:

`
cat my_file.txt | phawk '$display = $ln %2 ===0'
`

Will display all even numbered lines. 



 



