<?php


namespace App\Sso;


use CodeEdu\LaravelSso\Server as SsoServer;
use Jasny\ValidationResult;
use App\Models\User;

class Server extends SsoServer
{

    private $brokers = [
        '1' => 'secret1',
        '2' => 'secret2'
    ];


    /**
     * Authenticate using user credentials
     *
     * @param string $username
     * @param string $password
     * @return \Jasny\ValidationResult
     */
    protected function authenticate($username, $password)
    {
        if (!\Auth::guard('web')->validate(['email' => $username, 'password' => $password])) {
            return ValidationResult::error(trans('auth.failed'));
        }

        return ValidationResult::success();
    }

    /**
     * Get the secret key and other info of a broker
     *
     * @param string $brokerId
     * @return array
     */
    protected function getBrokerInfo($brokerId)
    {
        return !array_key_exists($brokerId, $this->brokers) ? null : [
            'id' => $brokerId,
            'secret' => $this->brokers[$brokerId]
        ];
    }

    /**
     * Get the information about a user
     *
     * @param string $username
     * @return array|object
     */
    protected function getUserInfo($username)
    {
        $user = User::whereEmail($username)->first();
        return !$user ? null : [
            'user' => $user,
        ];
    }
}
