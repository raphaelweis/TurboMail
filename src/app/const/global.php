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

// Username
const DATABASE_USER_NAME = 'root';

// Data Source Name (DSN) for PDO constructor
const DATA_SOURCE_NAME = 'mysql:host=' . HOST_NAME . ';dbname=' . DATABASE_NAME;

/**************/
/* User Table */
/**************/
// User table's name
const USER_TABLE = 'User';

// User table's attributes
const ID_USER_TABLE = 'id';
const FIRST_NAME_USER_TABLE = 'first_name';
const MAX_FIRST_NAME_LENGTH = 128;
const LAST_NAME_USER_TABLE = 'last_name';
const MAX_LAST_NAME_LENGTH = 128;
const EMAIL_USER_TABLE = 'email';
const MAX_EMAIL_LENGTH = 256;
const PASSWORD_USER_TABLE = 'password';
const MAX_PASSWORD_LENGTH = 256;
const MIN_PASSWORD_LENGTH = 8;

/*****************/
/* Message Table */
/*****************/
// Message table's name
const MESSAGE_TABLE= 'Message';

// Message table's attributes
const ID_MESSAGE_TABLE = 'id';
const ID_SENDER_MESSAGE_TABLE = 'id_sender';
const ID_RECEIVER_MESSAGE_TABLE = 'id_receiver';
const MESSAGE_MESSAGE_TABLE = 'message';
const DATE_MESSAGE_TABLE = 'date';

/******************/
/* Relation Table */
/******************/
// Relation table's name
const RELATION_TABLE = 'Relation';

// Relation table's attributes
const ID_RELATION_TABLE = 'id';
const ID_SENDER_RELATION_TABLE = 'id_sender';
const ID_RECEIVER_RELATION_TABLE = 'id_receiver';
const STATUS_RELATION_TABLE = 'status';

/***********/
/* Queries */
/***********/
// Insert queries
const REGISTER_QUERY = 'INSERT INTO ' . USER_TABLE. '(' . FIRST_NAME_USER_TABLE . ', ' . LAST_NAME_USER_TABLE . ', ' . EMAIL_USER_TABLE . ', ' . PASSWORD_USER_TABLE . ') VALUES (?, ?, ?, ?);';
const SEND_RELATION_QUERY = 'INSERT INTO ' . RELATION_TABLE . '(' . ID_SENDER_RELATION_TABLE . ', ' . ID_RECEIVER_RELATION_TABLE . ', ' . STATUS_RELATION_TABLE . ') VALUES (?, ?, ?);';
const INSERT_MESSAGE_QUERY = 'INSERT INTO ' . MESSAGE_TABLE . '(' . ID_SENDER_MESSAGE_TABLE . ', ' . ID_RECEIVER_MESSAGE_TABLE . ', ' . MESSAGE_MESSAGE_TABLE . ', ' . DATE_MESSAGE_TABLE . ') VALUES (?, ?, ?, ?);';

// Select queries
const LOGIN_QUERY = 'SELECT * FROM ' . USER_TABLE. ' WHERE ' . EMAIL_USER_TABLE . '=?;';
const SELECT_USER_BY_MAIL_QUERY = 'SELECT * FROM ' . USER_TABLE. ' WHERE ' . EMAIL_USER_TABLE . '=?;';
const SELECT_USER_ID_BY_MAIL_QUERY = 'SELECT '. ID_USER_TABLE . ' FROM ' . USER_TABLE . ' WHERE ' . EMAIL_USER_TABLE . '=?;';
const SELECT_RELATION_QUERY = 'SELECT * FROM ' . RELATION_TABLE . ' WHERE (' . ID_SENDER_RELATION_TABLE . '=? AND ' . ID_RECEIVER_RELATION_TABLE . '=?) OR (' . ID_SENDER_RELATION_TABLE . '=? AND ' . ID_RECEIVER_RELATION_TABLE . '=?);';
const SELECT_USER_RELATIONS_QUERY = 'SELECT * FROM ' . RELATION_TABLE . ' WHERE ' . ID_SENDER_MESSAGE_TABLE . '=? OR ' . ID_RECEIVER_RELATION_TABLE . '=?;';

/***********************/
/* Regular Expressions */
/***********************/
const NAMES_REGEX = "/^(?!\s)[a-zA-Z\'\-\sÀ-ÖØ-öø-ÿ]+$/u";
const PASSWORD_REGEX = "/^[a-zA-Z0-9\/!@#$%&*]+$/";
