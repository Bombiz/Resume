#******************************************************************************
#Software Designer: Kombiz Khayami
#Release Date:      April 4, 2014
#Course :           420 - 326 - AB Winter 2014
#Deliverable:       Assignment #3 - Password & User ID Generator 
#Description:       
#	script reads in a comma seperated file clients. clients can be poatfixed with any number. the file contains a list of last names and first names.
#   The application generates another file that contains last names, first names,  unique user ids, and passwords in a table formate.
#	user ids are generated by combining the first 3 letters of the first name with the first 3 letters of the last name.
#	if the user id generated already exists an integer COUNT is appended to it.
#	passwords are generated by combining 2 words from a file called 'words'.
#	words is a dictionary.
#******************************************************************************

#┏━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┓
#┃                                 INITILIZATION BLOCK					                  ┃
#┗━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┛

clear 

>$2                         #Clear the target file

grep -n '^' words > words1 #Creat a new list of words with number prefixs 
l=$(grep -c '^' words1)     #get count of  words in the word list 
l=$l+1                      

printf "╔══════════════════╦══════════════════╦══════════════════╦════════════════════════════════════════╗\n" >> $2
printf "║LAST NAME         ║FIRST NAME        ║USER ID           ║PASSWORD                                ║\n" >> $2
printf "╠══════════════════╬══════════════════╬══════════════════╬════════════════════════════════════════╣\n" >> $2

#┏━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┓
#┃                            LINE PROCESING BLOCK                                        ┃                                                            
#┗━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┛


while read zz
do
	#COUNT              // number of current generated user id in the file 
	#USER               // the current user name gererated 


    #******************************
    #*Getting the Name of the User*
    #******************************
    FIRST=$(echo $zz | cut -d, -f2)
    LAST=$(echo $zz | cut -d, -f1) 
    
    #**********************
    #*Generating USER ID'S*
    #**********************
    idfirst=$(echo $zz | cut -c1-3)
    idlast=$(echo $zz | cut -d, -f2  | cut -c2-4)
    USER=$idfirst$idlast					      

    #*******************************
    #*Checking for Unique USER ID'S*
    #*******************************
    COUNT=$(grep -c $USER $2)					       
    if [ "$COUNT" != 0 ];                          	      	               
    then
      USER=$USER$COUNT							       
    fi

    #**************************
    #*Generating user password* 
    #**************************
    rad1=$(perl randm.pl $l)                        #Get 2 randome numbers and select the words that have those numbers prefixed
    rad2=$(perl randm.pl $l)
    pass1=$(grep '^'$rad1':' words1 | cut -d: -f2)
    pass2=$(grep '^'$rad2':' words1 | cut -d: -f2)

    PASSWORD=$pass1$pass2

    printf "║%-18s%s%-18s%s%-18s%s%-40s%s\n" $LAST "║" $FIRST "║" $USER "║" $PASSWORD "║">> $2   #Output data to file in a table formate


done <$1
printf "╚══════════════════╩══════════════════╩══════════════════╩════════════════════════════════════════╝\n" >> $2

cat $2    #show contents of the created file
 