<?php

namespace fkooman\OAuth\Client;

class Context
{
    private $userId;
    private $scope;

    public function __construct($userId, Scope $scope)
    {
        $this->setUserId($userId);
        $this->setScope($scope);
    }

    public function setUserId($userId)
    {
        if (!is_string($userId) || 0 >= strlen($userId)) {
            throw new ContextException("userId needs to be a non-empty string");
        }
        $this->userId = $userId;
    }

    public function getUserId()
    {
        return $this->userId;
    }

    public function setScope(Scope $scope)
    {
        $this->scope = $scope;
    }

    public function getScope()
    {
        return $this->scope;
    }
}
