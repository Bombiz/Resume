#******************************************************************************
#Software Designer: Kombiz Khayami
#Release Date:      April 15, 2014
#Course :           420 - 326 - AB Winter 2014
#Deliverable:       Assignment #4 - A File Archiving Case Study 
#Description:
#       script 
#******************************************************************************

#╔═══════════════════════════════════════════════════╗
#║              COLOR CODES                          ║
#╚═══════════════════════════════════════════════════╝

NONE='\33[0m'
PURPLE='\033[35m'
GREEN='\033[32m'
YELLOW='\033[93m'
TURQUOISE='\033[96m'

#╔════════════════════════════════════════════════════════════════════════════════════════╗
#║                            ERROR HANDLING                                              ║
#╚════════════════════════════════════════════════════════════════════════════════════════╝

if [[ $# != 2 ]]    #if the user put in less then 2 parameters 
then
   printf "${TURQUOISE}Usage: $0 TargetFilePath LibraryPath\n${NONE}"
   exit 1
fi


if [[ $1 =~ "^/$" || -d $1 ]] #the target archiving file already exists as a directory?
then
   printf "${GREEN}The traget file already exists as a directory.\n${NONE}"
   exit 2
fi   


outputpath=$(dirname $1) #remove file name from the target path 



if [[ $outputpath!=$1 && !-d$outputpath ]] #check if the target directory exists
then   
   mkdir -p $outputpath                  #if not then make it
fi


if [[ ! -d $2 ]] #check if the script directory exists 
then
   printf "${YELLOW}Script Libary does not exist.\n${NONE}"
   exit 3
fi


if [[ ! $(ls -A $2) ]] #check if the script directory is empty 
then
  printf "${PURPLE}The Script Directry specified is empty.\n${NONE}"
  exit 4
fi

#╔═════════════════════════════════════════════════════════════╗
#║                     MAIN LOOP                               ║
#╚═════════════════════════════════════════════════════════════╝

old=$(pwd)


if [[ $1 =~ ^/ ]] #if the target archiving path is an absolut path
then
   arch=$1	  
else
   arch=$old/$1
fi

>$arch #clear the target file

exec 1> $arch  #write std output to the srchiving file



cd $2 # enter the 

#╔═════════════════════════════════════════════════════════════╗
#║                      ARCHIVING HEADER                       ║
#╚═════════════════════════════════════════════════════════════╝
echo ""
echo "####################################################"
echo "# To unpack this shell archive:                    #"
echo "# 1. Make this archive file executable using chmod #"
echo "# 2. Execute this archive file                     #"
echo "#                                                  #"
echo "# This archive contains the folowing files         #"
for i in *
do
        echo "#  $i                                      #"
done
echo "####################################################"
echo ""



#╔═════════════════════════════════════════════════════════════╗
#║                      ARCHIVING LOOP                         ║
#╚═════════════════════════════════════════════════════════════╝

for i in *
do
	echo "Now archiving $i" 1>&2
        echo "if [ ! -f $i ]"    #check if the files being unpacked already exists 
        echo "then"

        echo "echo "Now extracting $i""
        echo "sed 's#^ZZZZZ##' >$i <<'!TAT!TVAM!ASI!'"  #when unpacking remove the mail header guard
        sed 's/^/ZZZZZ/' $i				#place ... as a mail header guard 
        echo "!TAT!TVAM!ASI!" 
	echo "chmod 770 $i"				#make the unpacked file executable 

 	echo "else"
	echo "echo "$i already exists""
	echo "fi"       
	
done

exit 0
