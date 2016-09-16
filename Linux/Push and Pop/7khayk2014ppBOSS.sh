#══════════════════════════════════════════════════════════════════════════════════════════════════════
#Software Designer: Kombiz Khayami
#Release Date:      May 10th, 2014
#Course :           420 - 326 - AB Winter 2014
#Deliverable:       Assignment 6 - Directory Stack Functions
#Description:
#            script test the functionality of 3 functions using a set of 5 directory paths which are passed as parameters. Function are contained in file 7khayk2014pLIB. 
#			Functions tested are :
#                                    1. 7khaykPSH  - 	 mimics the pushd command
#                                    2. 7khaykPOP  -     mimics the popd command									
#                                    3. 7khaykDIRS -     mimics the dirs command 
#══════════════════════════════════════════════════════════════════════════════════════════════════════

#┏━━━━━━━━━━━━━━━━━━━━━━━━━━━━┓
#┃INITILIZATION BLOCK         ┃
#┗━━━━━━━━━━━━━━━━━━━━━━━━━━━━┛
source 7khayk2014ppLIB
u=1
v=2
w=3
x=4
y=5
z=0
#━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━

clear

#┏━━━━━━━━━━━━━━━━━━━━━━━━━━━━┓
#┃TESTING WITH EMPTY STACK    ┃
#┗━━━━━━━━━━━━━━━━━━━━━━━━━━━━┛
echo "┏━━━━━━━━━━━━━━━━━━━┓"
echo "┃EMPTY STACK ACTIONS┃"
echo "┗━━━━━━━━━━━━━━━━━━━┛"
echo;

echo "1.Display empty stack"
7khaykDIRS
read junk;
echo;
echo;


echo "2.Pop empty stack"
7khaykPOP
read junk;
echo;
echo;

echo "3.Swap top two of empty stack"
7khaykPSH
read junk;
echo;
echo;

echo "4.Cyclic pop of empty stack"
7khaykPOP +3
read junk;
echo;
echo;

echo "5.Cyclic push with no number"
7khaykPSH +
read junk;
echo;
echo;

echo "6.Push non-existent directory"
7khaykPSH ~/NotExisting
read junk;
echo;
echo;

clear
#┏━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┓
#┃TESTING WITH PASSED PARAMETERS     ┃
#┗━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┛
echo "┏━━━━━━━━━━━━━━━━━━━━━━━━┓"
echo "┃INPUT PARAMETERS ACTIONS┃"
echo "┗━━━━━━━━━━━━━━━━━━━━━━━━┛"
echo;


echo "1.Push parameter 1"
7khaykPSH ~/test/$1
read junk;
echo;
echo;

echo "2.Push parameter 2"
7khaykPSH  ~/test/$2
read junk;
echo;
echo;

echo "3.Push parameter 3"
7khaykPSH  ~/test/$3
read junk;
echo;
echo;

echo "4.Push parameter 4"
7khaykPSH  ~/test/$4
read junk;
echo;
echo;

echo "5.Push parameter 5"
7khaykPSH  ~/test/$5
read junk;
echo;
echo;

echo "6.Show stack"
7khaykDIRS
read junk;
echo;
echo;

echo "7.Plain pop"
7khaykPOP
read junk;
echo;
echo;

echo "8.Plain push with no arguments"
7khaykPSH 
read junk;
echo;
echo;

echo "9.Cyclic push with constant"
7khaykPSH +3
read junk;
echo;
echo;

echo "10.Cyclic pop with constant"
7khaykPOP +3
read junk;
echo;
echo;

echo "11.Plain push with no argument"
7khaykPSH
read junk;
echo;
echo;

echo "12.Show stack"
7khaykDIRS
read junk;
echo;
echo;

echo "13.Cyclic push with variable"
7khaykPSH +$w
read junk;
echo;
echo;

echo "14.Cyclic pop with variable"
7khaykPOP +$v
read junk;
echo;
echo;

echo "15.Plain pop"
7khaykPOP 
read junk;
echo;
echo;

echo "16.Cyclic pop with big argument"
7khaykPOP +6
read junk;
echo;
echo;

echo "17.Cyclic pop with no number"
7khaykPOP +
read junk;
echo;
echo;

echo "18.Show stack"
7khaykDIRS
read junk;
echo;
echo;

echo "19.Cyclic pop with argument 0"
7khaykPOP +0
read junk;
echo;
echo;

echo "20.Plain pop but stack is empty"
7khaykPOP 
read junk;
echo;
echo;