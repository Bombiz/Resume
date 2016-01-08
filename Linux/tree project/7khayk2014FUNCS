#╔═══════════════════════════════════════════════════════╗
#║                   INTERVALS                           ║
#║initialization of a set of graphic-fragments which are ║ 
#║used to draw the lines connecting the directory-tree   ║
#╚═══════════════════════════════════════════════════════╝

function initvars
{    incr="|   "
     lastincr="    "
     pfx="|-- "
     lpfx="\`-- "
}


#╔═══════════════════════════════════════════════════╗
#║              COLOR CODES                          ║      
#║    defines color constantsused used to            ║
#║      define the directory-tree                    ║
#╚═══════════════════════════════════════════════════╝
function setcolors
{
     NONE='\33[0m'
     PFX='\033[93m'    #YELLOW
     ERRORS='\033[32m' #GREEN
     DIRS='\033[96m'   #CYAN
     FILES='\033[31m'  #RED
     SIZE='\033[92m'   #LIGHT GREEN
}



#╔═══════════════════════════════════════════════════╗
#║              MY_TREE                              ║
#║creates the directory-tree by recursivly calling   ║
#║it self each time a new directory is encountered.  ║
#╚═══════════════════════════════════════════════════╝
function mytree
{       
     
     
     cd "$1" #enter tree target directory  
            
     local leader=$2 
     
     
     
      
      
     if [[ $Dopt == 0 ]]
     then 
         local nitems=$(ls . | grep -c ^) #get count of all the items in target directory 
     else 
         local nitems=$(ls -l . | grep -c ^d) #get the count of all the directories in target directory
     fi
    
        
        
     
     for i in *            #process all the items in the target directory
     do
       if [[ ! `ls -A` ]]  #skip empty directories
       then
           continue
       fi
      
       if [[ $Sopt == 1 ]] #begin Size processing 
       then
           filesize=$(stat -c%s "$i") #get the size of the current item being processed
           totalsize=$((filesize+totalsize)) #increase the total size of present working directory0
           filesize="($filesize) "
       fi

       if [[ $Dopt == 0 ]] #count all items if directory switch is off 
       then 
           let nitems--
       fi
       
       if [[ -d $i ]] #directory processing
       then

           if [[ $Dopt != 0 ]] #count directories in pwd if directory switch is on 
           then
               let nitems--
           fi
           
           let totaldirs++     #count the total amount of directories in tree target  

           if [[ $nitems != 0 ]] #if we have not reached the end of the pwd 
           then
               printf "${PFX}$leader$pfx${SIZE}$filesize${DIRS}$i\n${NONE}" #print out leader followed by prefix and name
               mytree "$i" "$leader$incr"                                   #recursive call to mytree
           else 
               printf "${PFX}$leader$lpfx${SIZE}$filesize${DIRS}$i\n${NONE}" #print out leader followed by the last prefix and name
               mytree "$i" "$leader$lastincr"                                #recursive call to mytree
           fi       

       else

           if [[ $Dopt == 0 ]] #process files if directory switch is off
           then
               let totalfiles++ #count the total amount of files    

               if [[ $nitems != 0 ]] #if we have not reached the end of the pwd 
               then
                   printf "${PFX}$leader$pfx${SIZE}$filesize${FILES}$i\n${NONE}"  #print out leader followed by prefix and file name
               else
                   printf "${PFX}$leader$lpfx${SIZE}$filesize${FILES}$i\n${NONE}" #print out last leader followed by the last prefix and file name
               fi
           fi
        fi

     done
     cd .. #move up 1 dir after we have processed all the items in pwd


}
