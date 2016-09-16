#******************************************************************************
#Software Designer: Kombiz Khayami
#Release Date:	    March 28, 2014
#Course :           420 - 326 - AB Winter 2014
#Deliverable:       Assignment #2 - Lab6
#Description:
#	Script Reads a campaign file and produces a report along with a table of that file. 
#	the report has a summery at the end that prints the total, lowest, highest, and average contributions.
#	The summary also shows the names and phone numbers of all the
#	people who donated more then $500.
#******************************************************************************   
  
#***************************BEGIN BLOCK****************************************
#prints the Tiltle of the report and colomn names
#******************************************************************************

BEGIN{ FS=":";  OFMT+"%.2f";total = 0; count = 0; 
print "\n\n\n"
print "                        ***FIRST QUARTERLY REPORT***"
print "                        ***CAMPAIGN 2000 CONTRIBUTIONS***"
print "--------------------------------------------------------------------------------"
print "NAME                  PHONE              Jan |     Feb |     Mar | Total Donated"
print "--------------------------------------------------------------------------------"
}
#*********************LINE PROCESSING BLOCK************************************

#totcon //total contribution for a person
#totdon //total donations for the campaign
#maxtotal //the maximum overall conribution 

{if (NR == 1)min = $3}				     #initializes minimum variable

#Finding the minimum/lowest contribution
{if (min > $3)min = $3}
{if (min > $4)min = $4}
{if (min > $5)min = $5}

#Finding the maximum/highest contribution
{if (max < $3)max = $3} 
{if (max < $4)max = $4} 
{if (max < $5)max = $5} 

{totcon=$3+$4+$5}				      #calculate the total contribution for 1 person
{totdon=totdon+totcon}	      		 	      #calculate the totat donations for the entire campaign 


#Print out the line with the persons total contribution in a neat formate
{printf "%-21s %-14s %9.2f %9.2f %9.2f %10.2f\n", $1, $2, $3, $4, $5, totcon}


{if (totcon > 500) print "   "$1"--"$2 | "sort -k2"}  #find everyone who donated more then $500 and sort them according to Last name

{if (maxtotal < totcon)split($1, m, " ")}    	      #get the name of the person with the highest overall contribution

{if (maxtotal < totcon)maxtotal = totcon}    	      #get the highest overall contribution

#******************************************************************************

#**************************END BLOCK*******************************************
#prints the summary of the script.
#******************************************************************************  

END{
avg = totdon/NR    #get the average donations for all contributors
print "--------------------------------------------------------------------------------"
print "				   SUMMARY"
print "--------------------------------------------------------------------------------"
printf "The campaign received a total of $%.2f for this quarter.\n", totdon
printf "The average donation for the %d contributors was $%.2f.\n", NR, avg
printf "The highest contribution was $%.2f.\n", max
printf "The lowest contribution was $%.2f.\n", min
printf "The highest total contribution was $%.2f made by %s %s.\n", maxtotal, m[1], m[2]
printf "\t\t      ***THANKS %s***\n", m[1]
printf "The following people donated over $500 to the campaign.\n"
printf "They are eligible for the quarterly drawing!!\n"
printf "Listed are their names (sorted by last names) and phone numbers:\n"
close("sort -k2")
printf "      Thanks to all of you for your continued support!!\n"
}