# CodeIgniter-Forrst

A wrapper for the Forrst.com API with CodeIgniter / PHP

## Requirements

1. PHP 5
2. curl
3. json_encode, json_decode

## Usage

There isn't too much to show here as the Forrst API is pretty slim at it's current state.

### User Info
$this->forrst->user_info('tomschlick');

### User Posts
$this->forrst->user_posts('tomschlick', $since_id, $last_id)