# TimberWolf
The link to an online version of the site: [Timberwolf](https://timberwolf.uni-mo.fr/).
Test credentials: henry.baker@example.com test021@Azert7

## Installation
### Cloning the GitHub repository:

Copy the git clone code
```bash 
https://github.com/Wanderlust-29/Projet3wa.git
```

### Using Wamp
Clone the GitHub repository into the `www` directory of your Wamp installation:

Make sure Wamp is running and the Apache server is started.

Here's an example of configuring environment variables in a `.env` file for your database:

#### Database info
```
DB_NAME="project"
DB_USER="johnDoe"
DB_PASSWORD="YourPassword"
DB_CHARSET="utf8"
DB_HOST="localhost"
```
In this file, you can set the necessary information for connecting to your database. Make sure to replace the values of `DB_USER`, `DB_PASSWORD`, and `DB_NAME` with your own login information.

Open the .env file and configure the values according to your needs, especially for connecting to the database.

Import the project's database into your database management system (e.g., phpMyAdmin).

### Installing Composer (for PHP dependencies) 

Download and install Composer by following the instructions on the official website: [Composer Download](https://getcomposer.org/download/).

Once Composer is installed, open a new terminal window and navigate to the project directory.

Run the following command to install the project's PHP dependencies:

```bash 
composer update
```

### Installing npm (for JavaScript dependencies)

Download and install Node.js from the official website: [Node.js Download](https://nodejs.org/).

Once Node.js is installed, open a new terminal window and navigate to the project directory.

Run the following command to install the project's JavaScript dependencies:
```bash
npm install
```

And that's it! You're ready to start working on the project!

**Note:** This project is a training assignment and is not intended for commercial use. The images used in this project are not free to use and may be subject to copyright restrictions.
