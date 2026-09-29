# 💸 Mercado Truchix - Billetera Virtual

Un sistema de base de datos relacional completo diseñado para gestionar la lógica de negocio de una billetera virtual (estilo Mercado Pago), con servicios propios e inversiones.

## 🎯 Sobre el Proyecto
Este proyecto fue desarrollado como trabajo práctico final para la materia **Base de Datos III**. El objetivo principal fue modelar, implementar y optimizar una base de datos robusta utilizando MySQL, e integrarla con una capa de presentación en PHP para demostrar su funcionamiento.

## ✨ Características Principales
- **Gestión de Usuarios y Cuentas:** Registro, login (con hashing de contraseñas) y perfiles.
- **Transacciones Financieras:** Transferencias, cargas de saldo, pagos y extracciones.
- **Servicios Propios:** Módulo para gestionar suscripciones (ej. "Truchix Play") y consumos.
- **Sistema de Inversiones:** Creación de inversiones, cálculo de rendimientos automáticos y movimientos.
- **Panel de Administración:** Dashboard con métricas y CRUD para usuarios y entidades clave.

## 🛠️ Tecnologías Utilizadas
- **Backend:** PHP 8+
- **Base de Datos:** MySQL / MariaDB
- **Frontend:** HTML5, CSS3, JavaScript (mínimo)
- **Control de Versiones:** Git y GitHub

## 🧠 Conceptos de Base de Datos Aplicados
- Diseño de Diagrama Entidad-Relación (DER) y normalización (1FN a 3FN).
- **10 Vistas** para reportes y abstracción de datos.
- **10 Procedimientos Almacenados** (incluyendo uso de Cursores y Handlers para control de errores).
- **10 Disparadores (Triggers)** para auditoría, validación y trazabilidad automática.
- Índices para optimización de consultas.

## 🚀 Instalación y Ejecución Local
Sigue estos pasos para levantar el proyecto en tu máquina:

1. Clona el repositorio:
   `git clone https://github.com/V-underEevee/mercado_truchix.git`
2. Copia la carpeta en `C:\xampp\htdocs\` y renómbrala a `Mercado_Truchix`.
3. Importa el archivo `sql/mercado_truchix.sql` en tu phpMyAdmin.
4. Abre en tu navegador: `http://localhost/Mercado_Truchix/`

### 👤 Credenciales de Prueba
- **Admin:** juan.perez@mail.com / 123456
- **Usuario:** maria.gomez@mail.com / 123456

## 👨‍💻 Autores
**[Guerri Bruno && Ramirez Lucas]**
- LinkedIn: [Bruno Guerri Bevilacqua](https://www.linkedin.com/in/bruno-guerri-bevilacqua-0ab617388/)
- GitHub: [@V-underEevee](https://github.com/V-underEevee)

- LinkedIn: [Lucas Ramirez](https://www.linkedin.com/in/lucas-ramirez-46707225b/)
- GitHub: [@sudoLucas](https://github.com/sudoLucas)
