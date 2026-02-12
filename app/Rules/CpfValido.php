<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CpfValido implements ValidationRule
{
    
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // 1. Limpa o CPF (deixa só números)
        $cpf = preg_replace('/\D/', '', (string) $value);

        // 2. Valida se tem 11 dígitos ou se é uma sequência repetida (111.111...)
        if (strlen($cpf) !== 11 || preg_match('/(\d)\1{10}/', $cpf)) {
            $fail('O CPF informado é inválido.');
            return;
        }

        // 3. Cálculo matemático dos dígitos verificadores
        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf[$c] != $d) {
                $fail('O CPF informado é inválido.');
                return;
            }
        }
    }
}