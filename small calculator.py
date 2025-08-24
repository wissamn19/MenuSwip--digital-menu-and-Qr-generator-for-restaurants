
welcoming = input('Welcome to our small calculator! please entre your name:')


print(f'Hello {welcoming}! , what do you want to calculate today?')

choose = input('1. Addition\n2. Subtraction\n3. Multiplication\n4. Division\n5. Modulus\nPlease enter the number of your choice: ')

if choose == '1':
    
    num1 = float(input('Please entre the first number:'))
    num2 = float(input('Please entre the second number:'))
    
    res = num1 + num2
    print(f'The result of the Addition of {num1} and {num2} is : {res}.')

elif choose == '2':
    
    num1 = float(input('Please entre the first number:'))
    num2 = float(input('Please entre the second number:'))
    
    res = num1 - num2
    print(f'The result of the Subtraction of {num1} and {num2} is : {res}.')

elif choose == '3':
    
    num1 = float(input('Please entre the first number:'))   
    num2 = float(input('Please entre the second number:'))  
    
    res = num1 * num2
    print(f'The result of the Multiplication of {num1} and {num2} is : {res}.')
    
elif choose == '4':
    
    num1 = float(input('Please entre the first number:'))
    num2 = float(input('Please entre the second number:'))

    if num2 == 0:
        print("Error: Division by zero is not allowed.")
    else:
        res = num1 / num2
        print(f'The result of the Division of {num1} and {num2} is : {res}.')
        
elif choose == '5':
    
    num1 = float(input('Please entre the first number:'))
    num2 = float(input('Please entre the second number:'))
    
    res = num1 % num2
    print(f'The result of the Modulus of {num1} and {num2} is : {res}.')

print(f'Thank you {welcoming} for using our calculator!')