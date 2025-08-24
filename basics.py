
print('hello world')

#these are strings
first_name = 'John'
last_name = 'Doe'
email = "fakenews@example.com"

print(first_name)

print(f"hello,{first_name} {last_name}") #f for formatted string
print(f"your email is :{email}") 

#integer
age = 21

print(f'your age is :{age} years old')

#float

price = 19.99
print(f"the price is : {price}$")

#boolean

is_student = True
print(f"are you a student ? {is_student}")

#typecasting = is the conversion of one data type to another
#explicit typecasting ( not automatic conversion)
print(type(first_name))
print(type(age))
print(type(price))
print(type(is_student))

age = float(age)
print(age)

price = int(price)
print(price)

is_student = str(is_student)
print(is_student)

#implicit typecasting (automatic conversion)

x = 2
y = 2.0

x = x / y

print(x)

#input

name = input("what is your name ? ")
print(f"hello , {name}")




