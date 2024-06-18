<?php

namespace Builder\Tables\Router\DTO;

/**
 * @summary: A ideia é obter as keys atraves desta tipagem usando classe, onde as propriedades sao buscadas dentro das variaveis super globais 
 * $_POST e/ou $_GET
 * @author : Lucas Cid <lucasfelipaaa@gmail.com>
 * @created 18/06/2024
 */
class SignInDTO 
{
    public string $email;
    public string $password;
} 