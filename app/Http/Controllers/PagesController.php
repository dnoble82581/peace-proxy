<?php

namespace App\Http\Controllers;

use App\Models\User;

class PagesController extends Controller
{
    public function editUser(int $userId)
    {
        if ($userId) {
            $user = User::findorFail($userId);
        }

        return view('pages.update-user')->with('user', $user);
    }

    public function editSubject($roomId)
    {
        return view('pages.subject.edit-subject')->with('roomId', $roomId);
    }

    public function admin($tenantId)
    {
        return view('pages.admin');
    }
}
