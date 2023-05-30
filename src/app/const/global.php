<?php

/************/
/* Database */
/************/
// Host's name
const HOST_NAME = 'localhost';

// Host's password
const HOST_PASSWORD = '';

// Database's name
const DATABASE_NAME = 'TurboMailDB';

// Model\Username
const DATABASE_USER_NAME = 'root';

// Data Source Name (DSN) for PDO constructor
const DATA_SOURCE_NAME = 'mysql:host=' . HOST_NAME . ';dbname=' . DATABASE_NAME . '';

/**************/
/* Model\User Table */
/**************/
// Model\User table's name
const USER_TABLE_NAME = 'User';

// Model\User table's attributes
const ID_USER_TABLE = 'id';
const FIRST_NAME_USER_TABLE = 'first_name';
const LAST_NAME_USER_TABLE = 'last_name';
const EMAIL_USER_TABLE = 'email';
const PASSWORD_USER_TABLE = 'password';

/*****************/
/* Model\Message Table */
/*****************/
// Model\Message table's name
const MESSAGE_TABLE_NAME = 'Model\Message';

// Model\Message table's attributes
const ID_MESSAGE_TABLE = 'id';
const ID_SENDER_MESSAGE_TABLE = 'id_sender';
const ID_RECEIVER_MESSAGE_TABLE = 'id_receiver';
const MESSAGE_MESSAGE_TABLE = 'message';
const DATE_MESSAGE_TABLE = 'date';

/******************/
/* Relation Table */
/******************/
// Relation table's name
const RELATION_TABLE_NAME = 'Relation';

// Relation table's attributes
const ID_RELATION_TABLE = 'id';
const ID_SENDER_RELATION_TABLE = 'id_sender';
const ID_RECEIVER_RELATION_TABLE = 'id_receiver';
const STATUS_RELATION_TABLE = 'status';

/***********/
/* Queries */
/***********/
// Login query
const LOGIN_QUERY = 'SELECT * FROM ' . USER_TABLE_NAME . ' WHERE ' . EMAIL_USER_TABLE . '=?;';

// Register query
const REGISTER_QUERY = 'INSERT INTO ' . USER_TABLE_NAME . '(' . FIRST_NAME_USER_TABLE . ',' . LAST_NAME_USER_TABLE . ',' . EMAIL_USER_TABLE . ',' . PASSWORD_USER_TABLE . ') VALUES (?, ?, ?, ?);';

// Select queries
const SELECT_USER_BY_MAIL_QUERY = 'SELECT * FROM ' . USER_TABLE_NAME . ' WHERE ' . EMAIL_USER_TABLE . '=?;';

/***********************/
/* Regular Expressions */
/***********************/

const NAMES_REGEX = "/^(?!\s)[a-zA-Z\'\-\sÀ-ÖØ-öø-ÿ]+$/u";
const PASSWORD_REGEX = "/^[a-zA-Z0-9\/!@#$%&*]+$/";
