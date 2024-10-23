opciones = ["cuadrado", "rectangulo", "salir"]

while True:  # Bucle infinito y se rompe cuando sea válida la opción
    figura = input("Elige cuadrado, rectángulo o salir: ").lower()

    if figura == "cuadrado":
        lado_cuadrado = int(input("Ingrese la longitud de los lados: "))
        print(f"El área del cuadrado es {lado_cuadrado**2}")
        print(f"El perímetro del cuadrado es {lado_cuadrado*4}")

        # dibujo del cuadrado, con el for lo que hacemos es que se repita tantas veces como sea el lado del cuadrado
        print("La figura del cuadrado:")
        for i in range(lado_cuadrado):
            print("* " * lado_cuadrado)
            continue
    

         

    elif figura == "rectangulo":
        base_rectangulo = int(input("Ingrese la longitud de la base: "))
        alto_rectangulo = int(input("Ingrese la altura del lado: "))
        print(f"El área del rectángulo es {base_rectangulo*alto_rectangulo}")
        print(f"El perímetro del rectángulo es {2*(base_rectangulo+alto_rectangulo)}")

        # dibujo del rectangulo, con el for lo que hacemos es que se repita tantas veces como sea la base e imprimira el alto esas tantas veces
        print("Aquí está tu rectángulo:")
        for i in range(alto_rectangulo):
            print("* " * base_rectangulo)
            continue

        

    elif figura == "salir":
        break

    else:
        print("Error, opción no válida. Vuelve a intentarlo.")
