#!/usr/bin/env php
<?php 

// Configuração das opções
$shortopts = "n::a::e::";  // Opções curtas: -n (nome), -a (idade), -e (email)
$longopts  = [
    "name::",  // Opção longa: --name
    "age::",   // Opção longa: --age
    "email::", // Opção longa: --email
];

// Obtenção dos argumentos
$options = getopt($shortopts, $longopts);

// Processamento dos argumentos
$name = $options['n'] ?? $options['name'] ?? 'default_name';
$age = $options['a'] ?? $options['age'] ?? 'default_age';
$email = $options['e'] ?? $options['email'] ?? 'default_email';

// Exibição dos valores
echo "Name: " . $name . "\n";
echo "Age: " . $age . "\n";
echo "Email: " . $email . "\n"; 