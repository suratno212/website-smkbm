<?php

if (!function_exists('debug_session')) {
    function debug_session() {
        $session = \Config\Services::session();
        $data = [
            'logged_in' => $session->get('logged_in'),
            'user_id' => $session->get('user_id'),
            'username' => $session->get('username'),
            'role' => $session->get('role'),
            'session_id' => $session->getSessionID()
        ];
        
        log_message('debug', 'Session data: ' . json_encode($data));
        return $data;
    }
}

if (!function_exists('is_logged_in')) {
    function is_logged_in()
    {
        return session()->get('logged_in') === true;
    }
}

if (!function_exists('get_user_role')) {
    function get_user_role() {
        return session()->get('role');
    }
}

if (!function_exists('get_user_id')) {
    function get_user_id() {
        return session()->get('user_id');
    }
}

if (!function_exists('is_admin')) {
    function is_admin()
    {
        return get_user_role() === 'admin';
    }
}

if (!function_exists('is_guru')) {
    function is_guru()
    {
        return get_user_role() === 'guru';
    }
}

if (!function_exists('is_siswa')) {
    function is_siswa()
    {
        return get_user_role() === 'siswa';
    }
} 