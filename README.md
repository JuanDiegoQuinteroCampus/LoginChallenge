# Login Challenge

Este repositorio contiene una prueba técnica cuyo objetivo es permitir el inicio de sesión en una aplicación.

## Instalación y configuración

### 1. Instalar PHP 8.2.4 en Ubuntu
Ejecuta los siguientes comandos en tu terminal:
```sh
sudo apt update
sudo apt install software-properties-common -y
sudo add-apt-repository ppa:ondrej/php -y
sudo apt update
sudo apt install php8.2 -y
```

Para verificar la instalación:
```sh
php -v
```
Debe mostrar una salida similar a:
```
PHP 8.2.4 (cli) (built: Mar 14 2023 07:22:00) ( NTS )
```

### 2. Instalar MySQL y soporte en PHP
Ejecuta el siguiente comando para asegurarte de que PHP tiene soporte para MySQL:
```sh
sudo apt-get install php*-mysql -y
```

### 3. Clonar el repositorio
```sh
git clone https://github.com/JuanDiegoQuinteroCampus/LoginChallenge.git
cd LoginChallenge
```

### 4. Configurar las variables de entorno
Dentro de la carpeta `backend`, copia el archivo `.env.example` y renómbralo como `.env`:
```sh
cp backend/.env.example backend/.env
```

### 5. Iniciar el servidor PHP
```sh
cd backend/src/
php -S localhost:8000 main.php
```

## Cómo funciona el programa
1. El usuario ingresa sus credenciales en la pantalla de inicio de sesión.
2. El sistema valida que las credenciales sean correctas.
3. Si las credenciales son correctas, el usuario es autenticado y redirigido a otra página.
4. La sesión tiene un tiempo límite de **una hora**. Después de este tiempo, la sesión se cerrará automáticamente.
5. El usuario también tiene la opción de cerrar sesión manualmente en cualquier momento.

## Credenciales de acceso
Para iniciar sesión en la aplicación, utiliza las siguientes credenciales:

- **Email:** juandiegoquintero2505@gmail.com
- **Contraseña:** contraseña

## Notas adicionales
- Asegúrate de que el puerto `8000` esté disponible en tu máquina.
- Si tienes problemas con la instalación de PHP o dependencias, revisa que todas las extensiones necesarias estén habilitadas.
- Si deseas usar un puerto diferente, puedes modificar el comando `php -S` según sea necesario.

