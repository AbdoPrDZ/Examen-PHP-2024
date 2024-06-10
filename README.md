# Examen PHP - User Authentication

## MCD:

![MCD](https://github.com/AbdoPrDZ/Examen-PHP-2024/docs/screenshots/mcd.png)

## Project files structure

- models: app tables models
  - User.php: the users table model
- resources: the app resources
  - css: the app css resources
    - bootstrap.min.css
  - js: the app js resources
    - bootstrap.bundle.min.js
- src: the sources
  - config.php: the app config
  - connection.php: the app database connection
  - session.php: the app session
- views: the app ready views
  - menu.php: the menu
- index.php: the first page
- login.php: the login page (users access)
- logout.php: the logout page (users logout)
- register.php: the register page (create users)
- user.php: the user page (user infos)
- users.php: the users page (all users infos)

## The client access steps:

- Open index page
- Chose the page from menu
  - Login:
    - Enter the exists user info to access
    - Check the sended infos:
      - Success:
        - Access to user page
        - Access to users page
      - Error:
        - Show errors
  - Register:
    - Enter the new user info
    - Check the sended infos:
      - Success:
        - Create the new user
        - Access to user page
        - Access to users page
      - Error:
        - Show errors
