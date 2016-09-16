// asst5v1.cpp       ALGORITHM DESIGN 306  
// arrays of infix strings, postfix strings, operands and operand-values
#include <iostream>
#include <iomanip>            #pragma warning(diable:4996) //for setw function to format output p
#include <math.h>       /* pow */
using namespace std;		   //standard namespace
////**********************GLOBAL VARIABLES****************************************
 const int LMAX = 50;        //maximum number of infix strings in array
 const int NMAX = 30;        //maximum size of each infix string
 const int LSIZE = 5;        //actual number of infix strings in the array infix
 const int NUMOPNDS = 10;    //number of different operands i.e. A through J
 const int MAXSTACK = 100;   //maximum number of items allowed in the stack structures
 int IDX;
 double val;
 char ifx[LMAX];//
 char pfx[LMAX];//
 bool underflow = true;

//array of infix strings
char infix[LMAX][NMAX] = { "A+B-C",
							"(A+B)*(C-D)", 
	                         "A$B*C-D+E/F/(G+H)",
							 "((A+B)*C-(D-E))$(F+G)", 
					    	 "A-B/(C*D$E)"  };			
//array of postfix strings
char postfix[LMAX][NMAX] = { "AB+C-",
							"AB+CD-*", 
	                         "AB$C*D-EF/GH+/+",
							 "AB+C*DE--FG+$", 
					    	 "ABCDE$*/-"  };
  
//arrays for the operands and their values
char opnd[NUMOPNDS] = {'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J'};
float opndval[NUMOPNDS] = { 3, 1, 2, 5, 2, 4, -1, 3, 7, 187};

//**********************STRUCTURES****************************************
struct OPERATOR_STACK
{   int top;
    char item[MAXSTACK];
};

struct OPERAND_STACK
{   int top;
    double item[MAXSTACK];
};

OPERATOR_STACK opstk;
OPERAND_STACK opndstk;

/****************************************************************************
						FUNCTIONS
****************************************************************************/
void convert(char[], char[]);
double eval(char[]);
//**********************OPERANDS****************************************
bool empty(OPERAND_STACK);//checks to see if the stack is empty
double pop(OPERAND_STACK&);//removes items from the stack
void dumpstack(OPERAND_STACK);//outputs the contents of the stack
void push(OPERAND_STACK&, double);//puts items on to the stack
//**********************OPERATORS****************************************
bool opterempty(OPERATOR_STACK);//checks to see if the stack is empty
char opterpop(OPERATOR_STACK&);//removes items from the stack
void opterdumpstack(OPERATOR_STACK);//outputs the contents of the stack
void opterpush(OPERATOR_STACK&, char);//puts items on to the stack
char optrpopandtest(OPERATOR_STACK&, char&);
//**********************CONVERSION***************************************
bool prcd(char, char);
int priority(char&);
int add=0;


int main() 
{
	opndstk.top = -1;
	opstk.top = -1;
	
	double val;

	   cout << setw(40) << "OPERANDS AND THEIR VALUES:" << endl << endl;
   for( int j=0; j<NUMOPNDS; j++)
 	   cout << setw(5) << opnd[j];
   cout << endl << endl;
   for( int j=0; j<NUMOPNDS; j++)
	   cout << setw(5) << opndval[opnd[j] - 'A'];
   printf("\n\n\n");
	
   printf("RESULTS:\n\n");	
	cout << "         INFIX EXPRESSION                POSTFIX RESULT                VALUE" << endl;
	printf("         ----------------		 --------------	               -----\n");
   for(IDX = 0; IDX <= LSIZE - 1; IDX++)
   {
	   strcpy(ifx, infix[IDX]);
	   convert(ifx, pfx);
	   val = eval(pfx);
	   cout << setw(25) << ifx << setw(30) <<pfx<< setw(21) << val << endl;
	   
	   system("pause");
   }
   printf("\n");

}

//*******************************FUNCTIONS***********************************

/****************************************************************************
                 CONVERSION FUNCTION: INFIX TO POSTFIX NOTATION
****************************************************************************/
void convert(char s[], char t[])
{
	char k;    //current character being processed
	char topsym = ' ';
	int j = 0;
	bool oper; //

	for ( int i = 0; i < strlen(s); i++ )//as long as their are more infix symboles
	{	k = s[i];
		if(isalpha(k))
			t[j++] = k;
		else
		{   optrpopandtest(opstk, topsym);
			while (!underflow && prcd(topsym, k))
			{   t[j++] = topsym;
				optrpopandtest(opstk, topsym);
			}

			if (!underflow)
				opterpush(opstk, topsym);

			if (underflow || k != ')')
				opterpush(opstk, k);
			else
				topsym = opterpop(opstk);
		}
	}

	for(opstk.top; opstk.top > -1; opstk.top--)
		t[j++] = opstk.item[opstk.top];
	t[j++] ='\0';
}

/****************************************************************************
					eval FUNCTION DEFINITION          
****************************************************************************/
double eval(char h[])
{
	char s;
	double op2;
	double op1;
	
	for(int i = 0; i<strlen(h);i++)
	{   s = h[i];
		if(s >= 'A' && s <= 'J')
			push(opndstk, opndval[s - 'A']);//takes s ASCII value and subtracts it from 'A' ASCII value.
		else
		{   op2 = pop(opndstk);
			op1 = pop(opndstk);
			switch(s)
			{   case '+':
					val = op1 + op2;
					break;
				case '-':
					val = op1 - op2;
					break;
				case '/':
					val = op1 / op2;
					break;
				case '*':
					val = op1 * op2;
					break;
				case '$':
					val = pow(op1, op2);
					break;
			}
			push(opndstk, val);
		}
	}
	return val;
}
/****************************************************************************
					OPERAND_STACK FUNCTIONS
****************************************************************************/
void dumpstack(OPERAND_STACK stack)
{   for( stack.top; stack.top > -1; stack.top-- )
		printf("%c\n", stack.item[stack.top]);
	printf("\n");
}
void push(OPERAND_STACK &stack, double stuff)
{   stack.top++;
	stack.item[stack.top] = stuff;
}
double pop(OPERAND_STACK &stack)
{   double i;//saves poped item 

	i=stack.item[stack.top]; //save poped item
	stack.top--;

	return i;
}
bool empty(OPERAND_STACK stk)
{   if( stk.top==-1 )
		return true;
	else
		return false;
}
/****************************************************************************
					OPERATOR_STACK FUNCTIONS
****************************************************************************/
void opterdumpstack(OPERATOR_STACK stack)
{   cout<<"| ";
	if(underflow == true)
		printf("Stack is empty |");
	for (int i = 0; i <= stack.top; i++)
		cout<< stack.item[i]<<" | ";

	printf("\n");
}
void opterpush(OPERATOR_STACK &stack, char stuff)
{	stack.top++;
	stack.item[stack.top] = stuff;
	if( stack.top <= -1 )
		underflow = true;
	else
		underflow = false;

}
char opterpop(OPERATOR_STACK &stack)
{   char i;

	i = stack.item[stack.top];
	stack.top--;

	return i;
}
char optrpopandtest(OPERATOR_STACK &stack, char &tops)
{   if(stack.top <= -1)
		underflow = true;
	else
	{	tops = stack.item[stack.top];
		stack.top--;
		underflow = false;
	}

	return tops;
}
bool opterempty(OPERATOR_STACK stk)
{   if (stk.top == -1)
		return true;
	else
		return false;
}
bool prcd(char left, char right)
{   bool q;
	if(left== '(')
		q = false;
	else 
		if(right == '(')
			q = false;
		else
			if(right == ')')
				q = true;
			else
				if(left == '$' && right == '$')
					q = false;
				else
					if(priority(left)>=priority(right))
						q = true;
					else
						q = false;
	return q;
}
int priority(char &op)
{   int p;

	switch(op)
	{   case '+':
		case '-':
			p = 1;
			break;
		case '*':
		case '/':
			p = 2;
			break;
		case '$':
			p = 3;
			break;
	}
	return p;
}