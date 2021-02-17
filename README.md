# PORTFOLIO

## Purpose

This is my portfolio, it presents:

- my skills;
- my projects;
- my developments;
- my CV;
- my social networks


## Requirements

- This project was made with symfony 5: https://symfony.com/doc/current/index.html
- Php ^7.2 http://php.net/manual/fr/install.php;
- Composer https://getcomposer.org/download/;


## Installation

1. Clone the current repository.

2. With mysql, create a **portfolio** database and create a user. Don't forget to give the rights to the user.
> If you want to use another service, see the official symfony documentation

3. Move into the directory and create an `.env.local` file (copy env file). **This one is not committed to the shared repository.**

4. Uncomment line DATABASE_URL=mysql, set `db_name` to **portfolio** and set the user `db_user` and the password `db_password`.
> Make sure the connection with the base is functional

5. Enter your information to configure your email address on line **MAILER_DSN=...**.

6. Enter your adress email on line **MAILER_FROM_ADDRESS=...**. This address will be the one with which you send emails.
> For exemple: admin@clement-dev.com

7. Execute the following commands in your working folder to install the project:

```bash
# Install dependencies
composer install

# Delete 'portfolio' DB for verifiy the connection
php bin/console d:d:d --force

# Create 'portfolio' DB
php bin/console d:d:c

# Execute migrations and create tables
php bin/console d:m:m
```

8. Go on the /init page and register you as an admin user : you have to put an email address and a password

> Reminder: Don't use composer update to avoid problem

> Assets are directly into _public/_ directory, **we will not use** Webpack with this project


## Usage

Launch the server with the command below

```bash
$ symfony server:start
```
