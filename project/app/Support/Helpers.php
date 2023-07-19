<?php

/**
 * All files in this folder will be included in the application.
 */

if (!function_exists('current_user')) {
    /**
     * Retorna uma instância do usuário corrente.
     *
     * @return \App\Domains\Auth\Models\User
     */
    function current_user()
    {
        return auth()->user();
    }
}
