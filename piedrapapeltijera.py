
import random 

opciones = ["tijera", "papel", "piedra"]

victorias_usuario = 0
victorias_ordenador = 0
    
while victorias_usuario < 3 and victorias_ordenador < 3:
    
    usuario = input("Elige piedra, papel o tijera:").lower()
    ordenador = random.choice(opciones)

    if usuario not in opciones:
        print("Error")
        continue

    if usuario == ordenador:
        print(f"El ordenador eligio {ordenador}")
        print("Empate")
        print(f"Marcador -> Usuario: {victorias_usuario}, Ordenador: {victorias_ordenador}")
    elif usuario == "tijera" and ordenador == "piedra" \
        or usuario == "piedra" and ordenador == "papel" \
            or usuario == "papel" and ordenador == "tijera": 
        victorias_ordenador += 1
        print(f"El ordenador eligio {ordenador}")
        print("Has perdido")
        print(f"Marcador -> Usuario: {victorias_usuario}, Ordenador: {victorias_ordenador}")
    else:
        victorias_usuario += 1
        print(f"El ordenador eligió {ordenador}")
        print("Has ganado")
        print(f"Marcador -> Usuario: {victorias_usuario}, Ordenador: {victorias_ordenador}")

if victorias_usuario == 3:
    print("Ha ganado el juego")
else:
    print("Ha perdido el juego")




