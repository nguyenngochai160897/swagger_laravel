<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
version: "3"

networks:
  user_app_network:
    driver: bridge

services:
  database:
    container_name: intern-be-mysql-dev
    image: mysql:5.7
    environment:
      MYSQL_USER: admin
      MYSQL_PASSWORD: admin123
      MYSQL_ROOT_PASSWORD: root
      MYSQL_DATABASE: project_manager
    volumes:
    - ./mysql:/var/lib/mysql
    - ${WORKING_DIR}:/home
    ports:
      - "8215:3306"
    restart: always

  phpmyadmin:
    container_name: intern-be-phpmyadmin-dev
    image: phpmyadmin/phpmyadmin
    links:
      - database:db
    depends_on:
      - database
    ports:
      - "8211:80"
    restart: always


  nginx:
    build:
      context: ./nginx
    env_file:
      - .env
    container_name: ${APP_NAME}_nginx
    ports:
      - ${HTTP_PORT}:80
      - 8213:81
      - 8214:82
      - ${HTTPS_PORT}:443
    volumes:
      - ${WORKING_DIR}:/var/www
      - ./nginx:/etc/nginx/conf.d
      - ./ssl:/etc/nginx/ssl
    working_dir: /var/www
    networks:
      - user_app_network
    links:
      - web
    restart: always

  web:
    build:
      context: ./web
      args:
        - PHP_VERSION=${PHP_VERSION}
    env_file:
      - .env
    container_name: ${APP_NAME}_web
    volumes:
      - ${WORKING_DIR}:/var/www
    working_dir: /var/www
    networks:
      - user_app_network
    restart: always

