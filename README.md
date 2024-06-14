# TimberWolf

## Project Description
TimberWolf is a final year e-commerce project designed for selling products for dogs. It also includes a section dedicated to dog adoption. This project is a training assignment and is not intended for commercial use. The images used in this project are not free to use and may be subject to copyright restrictions.

## Online Version
An online version of the site is available at: [Timberwolf](https://timberwolf.uni-mo.fr/).
Test credentials: 
- Email: henry.baker@example.com 
- Password: test021@Azert7

## Prerequisites
Before you begin, ensure you have the following software installed on your system:
- Wamp
- Composer
- Node.js
- 
## Installation
### Cloning the GitHub repository:

Copy the git clone code
```bash 
https://github.com/Wanderlust-29/Projet3wa.git
```

### Using Wamp
Clone the GitHub repository into the `www` directory of your Wamp installation:

Make sure Wamp is running and the Apache server is started.

### Configuring Environment Variables
Create a `.env` file in the project root and configure it with your database information:

#### Database info
```
DB_NAME="project"
DB_USER="johnDoe"
DB_PASSWORD="YourPassword"
DB_CHARSET="utf8"
DB_HOST="localhost"
```
Replace DB_USER, DB_PASSWORD, and DB_NAME with your own database credentials.

### Database Setup

### Installing Composer (for PHP dependencies) 
Import the project's database into your database management system (e.g., phpMyAdmin):

- Open phpMyAdmin or your preferred database management tool.
- Create a new database named project.
- Import the provided SQL file into the newly created database.

### Installing PHP Dependencies

Navigate to the project directory and install PHP dependencies using Composer:

```bash 
composer install
```

update dependencies
```bash
composer update
```

### Installing JavaScript Dependencies

Navigate to the project directory and install JavaScript dependencies using npm:
```bash
npm install
```

## Running the Project

Ensure that Wamp is running and the Apache server is started.
Open your web browser and navigate to http://localhost/your-project-directory.

## Troubleshooting
Wamp Issues: Ensure that no other programs are using the same port as Apache (usually port 80).
Composer Issues: Make sure you have the latest version of Composer installed.
Node.js Issues: Ensure that Node.js and npm are correctly installed and their versions are up to date.

## License
This project is licensed under the MIT License.
