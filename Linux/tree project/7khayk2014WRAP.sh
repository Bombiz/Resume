#══════════════════════════════════════════════════════════════════════════════════════════════════════
#Software Designer: Kombiz Khayami
#Release Date:      April 26, 2014
#Course :           420 - 326 - AB Winter 2014
#Deliverable:       Assignment #5 - Directory Tree Project
#Description:
#       script mimics the BASH tree command by calling subordinate funtions that are found in a script libary FUNCS. 
#       FUNCS countains 3 funtions. initvars, setcolors, and mytree.    
#       The beginning of the script checks for option inputs error handling. 
#       the user is allowed to enter 2 options. -d wich only shows directories and 
#       -s wich displays the size of the file or directory just before the name of the file or directory.
#       If any errors are found script outputs an error message in a specific color and exits7khayk2014FUNCS.
#       
#══════════════════════════════════════════════════════════════════════════════════════════════════════

source 7khayk2014FUNCS #calling script FUNCS 
initvars               #call funtion intvars to initialize variables 
setcolors              #call funtion setcolors to define colors


null_leader=""         #initialize passed leader to null

#╔═══════════════════════════════════════════════════╗
#║              OPTIONS PROCESSING                   ║
#╚═══════════════════════════════════════════════════╝

Dopt=0 #Directories only switch 
Sopt=0 #File and Directory Size switch

while getopts ds options 2> /dev/null
do
    case $options in

          d) echo "-d shows direcories only"    
             let Dopt=1;; 
	  s) echo "-s displays the size of the file or directory just before the name of the file or directory" 
             let Sopt=1;;
          \?) echo "Usage: $0 [-ds]" 
              exit 1;;
    esac
done
shift $(( $OPTIND - 1 )) #get rid of option parameters  


#╔═══════════════════════════════════════════════════╗
#║              ERROR HANDLING                       ║
#╚═══════════════════════════════════════════════════╝

if [[ $# > 1 ]] #check if the number of prameters passed is more then one 
then
   printf "${ERRORS}Error: too many arguments where passed \n${NONE}"
   exit 2
fi


if [[ $# == 1 ]] #only one parameter is passed 
then
   if [[ -d $1 ]] #if the parameter passed is a directory
   then
      target=$1   #set tree target to passed parameter
   else           #ouput error if the parameter passed is not a directory 
      printf "${ERRORS}Error: Target specified is not a directory \n${NONE}"
      exit 3      
   fi
else
   target=$(pwd) #set tree target to the pwd
fi


#╔═══════════════════════════════════════════════════╗
#║                    LEGEND                         ║
#║   outputs a legend for the tree produced          ║
#╚═══════════════════════════════════════════════════╝
if [[ $Sopt == 1 ]]
then
    printf "\n\n**********************************\n"
    printf "*${FILES}Red = Files ${NONE}%21s\n*${DIRS}Cyan = Directories${NONE}%15s\n${SIZE}*Light Green = File size in bytes${NONE}%s\n${DIRS}${NONE}" "*" "*" "*"
    printf "**********************************\n\n\n"
    printf "${DIRS}$1\n${NONE}"
else
    printf "\n\n*************************\n"
    printf "*${FILES}Red = Files ${NONE}%12s\n*${DIRS}Cyan = Directories${NONE}%6s\n${DIRS}${NONE}" "*" "*"
    printf "*************************\n\n\n"
    printf "${DIRS}$1\n${NONE}"
fi


mytree $target $null_leader #call funtion my tree passing it target directory and an initialized leader

#╔═══════════════════════════════════════════════════╗
#║            POST PROCESSING BLOCK                  ║
#║       outputs certain statistice about            ║ 
#║           the target directory                    ║
#╚═══════════════════════════════════════════════════╝

if [[ $Sopt == 1 && $Dopt == 1 ]]
then
        printf "\n$totaldirs Directories"
        printf "\nTotal size of $target is $totalsize byts\n"
        exit
fi


if [[ $Sopt == 1 && $Dopt == 0 ]]   
then
    printf "\n$totaldirs Directories, $totalfiles files"
    printf "\nTotal size of $target is $totalsize byts\n"
else 
    if [[ $Dopt == 1 ]]
    then
        printf "\n$totaldirs Directories\n"
    else
        printf "\n$totaldirs Directories, $totalfiles files\n"
    fi 
fi


