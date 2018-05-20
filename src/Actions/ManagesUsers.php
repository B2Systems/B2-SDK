<?php

namespace B2Systems\B2\Actions;

use B2Systems\B2\Resources\User;

trait ManagesUsers
{
    /**
     * Get the collection of users.
     *
     * @param  integer $organisationId
     * @return User[]
     */
    public function users($organisationId)
    {
        return $this->transformCollection(
            $this->get("organisations/$organisationId/users")['users'],
            User::class,
            ['organisation_id' => $organisationId]
        );
    }

    /**
     * Get a user instance.
     *
     * @param  integer $userId
     * @param  integer $organisationId
     * @return User
     */
    public function user($userId, $organisationId)
    {
        return new User(
            $this->get("organisations/$organisationId/users/$userId")['user'], $this
        );
    }

    /**
     * Create a new user.
     *
     * @param  integer $organisationId
     * @param  array $data
     * @param  boolean $wait
     * @return User
     */
    public function createUser($organisationId, array $data, $wait = true)
    {
        $user = $this->post("organisations/$organisationId/users", $data)['user'];
        if ($wait) {
            return $this->retry($this->getTimeout(), function () use ($organisationId, $user) {
                return $this->user($organisationId, $user['id']);
            });
        }
        return new User($user + ['organisation_id' => $organisationId], $this);
    }

    /**
     * Delete the given user.
     *
     * @param  integer $organisationId
     * @param  integer $userId
     * @return void
     */
    public function deleteUser($organisationId, $userId)
    {
        $this->delete("organisations/$organisationId/users/$userId");
    }
}
