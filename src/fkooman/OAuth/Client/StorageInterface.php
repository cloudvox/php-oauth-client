<?php

namespace fkooman\OAuth\Client;

interface StorageInterface
{
    public function storeAccessToken(AccessToken $accessToken);
    public function getAccessToken($clientConfigId, Context $context);
    public function deleteAccessToken(AccessToken $accessToken);

    public function storeRefreshToken(RefreshToken $refreshToken);
    public function getRefreshToken($clientConfigId, Context $context);
    public function deleteRefreshToken(RefreshToken $refreshToken);

    public function storeState(State $state);
    public function getState($clientConfigId, $state);
    public function deleteState(State $state);
    public function deleteStateForContext($clientConfigId, Context $context);
}
