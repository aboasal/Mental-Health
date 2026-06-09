<?php
// models/User.php

class User
{
    protected int $id;
    protected string $fullName;
    protected string $email;
    protected string $role;

    public function __construct(string $fullName, string $email, string $role)
    {
        $this->fullName = $fullName;
        $this->email = $email;
        $this->role = $role;
    }

    public function getRole(): string
    {
        return $this->role;
    }

    // Additional common methods (e.g., authentication, password reset)
}
