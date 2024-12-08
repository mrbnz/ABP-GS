# Aplicació Web de Gestió d'Usuaris i Activitats

## **Descripció del Projecte**
Aquest projecte és una aplicació web que gestiona usuaris, activitats i inscripcions. Està desenvolupat seguint el patró de disseny **MVC (Model-View-Controller)** i utilitza **PHP** per a la lògica del servidor. A continuació es detallen les funcionalitats principals del sistema:

---

## **Funcionalitats Principals**
- **Gestió d'Usuaris:**
  - Els usuaris poden registrar-se, iniciar sessió, actualitzar el seu perfil i canviar la seva contrasenya.
  - Els administradors tenen la capacitat d'editar i eliminar usuaris.

- **Gestió d'Activitats:**
  - Els usuaris poden veure una llista d'activitats disponibles i inscriure's a elles.
  - Els administradors poden crear, editar i assignar activitats.

- **Sistema d'Autenticació:**
  - Inclou funcionalitats de registre, inici de sessió i tancament de sessió.
  - Els usuaris autenticats poden accedir a les seves dades personals i modificar-les.

- **Interfície d'Usuari:**
  - Utilitza plantilles HTML amb **Bootstrap** per proporcionar una interfície d'usuari moderna i responsiva.

---

## **Estructura del Projecte**
- **`bundle/`**: Conté els directoris per a cada "Classe" amb les subcarpetes:
  - `controllers/`
  - `models/`
  - `templates/`
  - `views/`

- **`config/`**: Inclou fitxers de configuració com `baseDeDades.php`.

- **`cache/`**: Utilitzada per **Twig** per emmagatzemar plantilles preformatades.

- **`images/`**: Directori per a imatges i altres recursos multimèdia.

- **`tools/`**: Eines i scripts SQL per a la creació de la base de dades i taules inicials.

- **`vendors/`**: Conté mòduls externs i eines internes.

---

## **Requisits del Sistema**
- **Servidor Web:** Apache o Nginx
- **PHP:** Versió 7.4 o superior
- **Base de Dades:** MySQL

---

## **Instal·lació**
1. **Clona el repositori al teu servidor web:**

   ```bash
   git clone https://github.com/mrbnz/ABP-GS
