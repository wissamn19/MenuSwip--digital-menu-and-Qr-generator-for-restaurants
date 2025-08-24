#conditional expressions : its one-line shortcut of the if else statement

num = 3 

print('positive' if num > 0 else 'negative')

result = 'EVEN' if num % 2 == 0 else 'ODD'

print(result)

a = 3
b = 5

max_num = a if a > b else b
min_num = a if a < b else b
print(max_num)
print(min_num)

age = 21

status = 'adult' if age >= 18 else 'child'

print(status)

user_role = 'guest'

access = 'full access' if user_role == 'admin' else 'limited access'

print(access)



# while  loop

name = input("what is your name?")

while name == '':
    print(' you didn\'t enter your name')
    name = input("what is your name?")
print(f'hello {name}')


age = int(input('what is your age?'))

while age < 0:
    print('age can\'t be negative')
    age = int(input('what is your age?'))
print(f'your age is {age} years old.')



food = input('what is your favorite food? (q to quite)?')

while not food == 'q':
    print(f'your favorite food is {food}')
    food = input('what is your second favorite food? (q to quite)?')
print('thank you for using our program!')