<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Contracts\User as SocialUser;
use Laravel\Socialite\Facades\Socialite;

class AuthGithub extends Controller
{
    public function callback()
    {
        $user = Socialite::driver('github')->user();
        $user->getId();
        $user->getNickname();
        $user->getName();
        $user->getEmail();
        $user->getAvatar();

        $account = $this->findUserByEmail($user->getEmail());
        if (!$account) {
            $account = $this->createNewAccount($user);
        }
        Auth::login($account);
        return redirect('/dashboard');
    }

    private function findUserByEmail(string $email): ?User
    {
        return User::where('email', $email)->first();
    }

    private function createNewAccount(SocialUser $user): User
    {
        $account = new User([
            'name' => $user->getName(),
            'email' => $user->getEmail(),
            'auth_method' => 'github',
//            'email_verified_at' => date('Y-m-d H:i:s'),
            'password' => Hash::make(uniqid())
        ]);
        $account->save();
        return $account;
    }

}
