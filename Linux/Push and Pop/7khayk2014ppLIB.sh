#══════════════════════════════════════════════════════════════════════════════════════════════════════
#Software Designer: Kombiz Khayami
#Release Date:      May 10th, 2014
#Course :           420 - 326 - AB Winter 2014
#Deliverable:       Assignment #6 - Directory Stack Functions
#Description:
#             script library that contains 4 functions. 7khaykPSH, 7khaykPOP, and 7khaykDIRS that mimic the 
#             pushd, popd, and dirs commands respectively and getNdirs wich gets the nth directory from the Directory stack.
 
#══════════════════════════════════════════════════════════════════════════════════════════════════════
DIRcount=1 #//the size of the stack
#DIR_STACK  // stack of directories that the user builds 
    
#╔══════════════════════════════════════════════════════════════════════════════════════════════════════╗
#║              PUSH FUNCTION                                                      						║      
#║puts a directory onto the stack.   if function is called with no parameters                           ║
#║passed it swaps the top 2 directories.  it a directory path is sent as a parameter                    ║
#║then it gets pushed onto the top of the stack. if a '+' followed by a number or variable (7khayPSH +n)║
#║is passed then the stack is rotated until the nth directory is the new top of the stack,              ║
#║then cds to the new top of the stack.      											 				║
#╚══════════════════════════════════════════════════════════════════════════════════════════════════════╝

function 7khaykPSH
{
dname=$1 #parameter passed 
plus=$(echo $1 | cut -c1)
#╔══════════════════════════════════╗
#║SWAPING TOP 2 DIRECTORIES OF STACK║
#╚══════════════════════════════════╝
if [ $# == 0 ]                                      #if no parameters where passed 
then
       if [ $DIRcount != 1 ] && [ $DIRcount != 0 ]  #if stack size is bigger then 1
       then                                         
                                                    #swap the top 2 directories on the stack 
           top=${DIR_STACK%%&*}
           topERASED=${DIR_STACK#*&}
           second=${topERASED%%&*}
           base=${topERASED#*&}
           DIR_STACK=$second"&"$top"&"$base

           echo $DIR_STACK

           cd $second                              #cd to the top of the stack
       else
           echo "Stack is already Empty: you are still in $PWD"
       fi
else
#╔══════════════════════════════════╗
#║    ROTATE STACK                  ║
#╚══════════════════════════════════╝
    if [ "$plus" == "+" ]     #if the user passed +n    
    then
        nth=${1#+}            #get the number/variable  
        
        if [ -n "$nth" ]      #if a number was passed
        then
             if [ -n "$DIR_STACK" ]              #if the stack is not empty 
             then                                #rotate the stack until the nth directory is at the top
                 getNdirs $DIR_STACK $nth        
                 DIR_STACK=$TMP_STACK$stackFRONT
                 FRONT=${DIR_STACK%%&*}
                 cd $FRONT
                 echo "$DIR_STACK"
             else
                 echo "Empty Stack"
             fi
        else
             echo "no number entered"
        fi
    else
#╔══════════════════════════════════╗
#║     ADDING TO TOP OF STACK       ║
#╚══════════════════════════════════╝
        if [ -n $dname ] && [ \( -d $dname \) -a \( -x $dname \) ] #if NOT NULL and directory exists and not a file
        then                                                       #add directory to top of the stack 
                let DIRcount++                                     #increase the size of the stack
                DIR_STACK="$dname&${DIR_STACK:-$PWD"&"}"           
                cd $dname
                echo $DIR_STACK
        else
                echo "Bad or missing directory: you are still in $PWD"
        fi
    fi
fi
}

#╔════════════════════════════════════════════════════════════════════════════════════════════════════════════╗
#║             POP FUNCTION                          														  ║
#║remove directories from the directory stack. if the user calls function with out 							  ║
#║any arguments then the top of the stack is removed.if the user calls function with a 					      ║
#║'+' followed by a number (7khayPOP +n) or variable (7khayPOP +$n) the nth directory on the stack is removed.║
#╚════════════════════════════════════════════════════════════════════════════════════════════════════════════╝
function 7khaykPOP
{
plus=$(echo $1 | cut -c1)           #get the first character 

if [ "$plus" == "+" ]               #if the user passed +n 
then
    nth=${1#+}                      #get number/variable passed
    if [ $nth > $DIRcount ]        #if number passed is bigger then stack size
    then
        if [ -n "$DIR_STACK" ]      #if the stack is not empty
        then
            nth=$(( $nth % DIRcount ))  #get its modules 
        fi
    fi
fi


#╔═══════════════════╗
#║POPING TOP OF STACK║
#╚═══════════════════╝
if [[ $# == 0  ||  $nth == 0 ]]                #if no parameters where passed or if the number passed was 0
then
       if [ -n "$DIR_STACK" ]    			   #if the stack is not empty
       then
                DIR_STACK=${DIR_STACK#*&} 	   #remove the top of the stack
				let DIRcount--            	   #decrease the size of the stack
                if [ -n "$DIR_STACK" ]         #if the stack is still not empty
                then
                    cd ${DIR_STACK%%&*}        #cd to the top of the stack
                    echo "$DIR_STACK"
                else
                    echo "Stack is now empty:  you are still in $PWD"
                fi
       else
            echo "Stack is already Empty: you are still in $PWD"  
       fi
else
#╔═════════════════════════════╗
#║POPING NTH DIRECTORY OF STACK║
#╚═════════════════════════════╝
    if [ "$plus" == "+" ]                     
    then             
        if [ -n "$nth" ]                                  #if a number was passed
        then
             if [ -n "$DIR_STACK" ]                       #if the stack is not empty
             then                                         #remove the nth directory from the stack
                 getNdirs "$DIR_STACK" "$nth"             
                 stackFRONT=${stackFRONT%&*&}             
                 DIR_STACK=$stackFRONT"&"$TMP_STACK       
                 let DIRcount--                            #decrease the size of the stack
                 echo "$DIR_STACK"
             else
                 echo "Stack is already Empty: you are still in $PWD"
             fi

        else
            echo "Please enter a number"
        fi
    fi
fi
}

#╔═══════════════════════════════════════════════════════════╗
#║             DISPLAY STACK FUNCTION     i.e. like dirs     ║
#╚═══════════════════════════════════════════════════════════╝
function 7khaykDIRS
{
if [ -n "$DIR_STACK" ]
then
    echo $DIR_STACK
else
    echo "Stack is Empty"
fi
}


#╔═══════════════════════════════════════════════════════════╗
#║                   GETNDIRS  								 ║
#║           gets the Nth directory							 ║
#╚═══════════════════════════════════════════════════════════╝
function getNdirs
{
   stackFRONT=""
   count=0                            #counter variable   
   TMP_STACK=$1                       #creates a temporary stack to modify

    while [ "$count" != "$2" ]        #loop through the stack until we have reached the nth directory
   do
      FRONT=${TMP_STACK%%&*}          #get the current top of stack
      stackFRONT=$stackFRONT$FRONT"&" #save 
      TMP_STACK=${TMP_STACK#*&}
      let count++                     #increase counter variable
    done
   
}





