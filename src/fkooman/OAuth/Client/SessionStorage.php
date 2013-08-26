<?php

namespace fkooman\OAuth\Client;

class SessionStorage implements StorageInterface
{
    public function __construct()
    {
        if ("" === session_id()) {
            // no session currently exists, start a new one
            session_start();
        }
    }

    public function getAccessToken($clientConfigId, Context $context)
    {
        if (!isset($_SESSION['php-oauth-client']['access_token'])) {
            return false;
        }

        foreach ($_SESSION['php-oauth-client']['access_token'] as $t) {
            $token = unserialize($t);
            if ($clientConfigId !== $token->getClientConfigId()) {
                continue;
            }
            if ($context->getUserId() !== $token->getUserId()) {
                continue;
            }
            if (!$token->getScope()->hasScope($context->getScope())) {
                continue;
            }

            return $token;
        }

        return false;
    }

    public function storeAccessToken(AccessToken $accessToken)
    {
        if (!isset($_SESSION['php-oauth-client']['access_token'])) {
            $_SESSION['php-oauth-client']['access_token'] = array();
        }

        array_push($_SESSION['php-oauth-client']['access_token'], serialize($accessToken));

        return true;
    }

    public function deleteAccessToken(AccessToken $accessToken)
    {
        if (!isset($_SESSION['php-oauth-client']['access_token'])) {
            return false;
        }

        foreach ($_SESSION['php-oauth-client']['access_token'] as $k => $t) {
            $token = unserialize($t);
            if ($accessToken->getAccessToken() !== $token->getAccessToken()) {
                continue;
            }
            unset($_SESSION['php-oauth-client']['access_token'][$k]);

            return true;
        }

        return false;
    }

    public function getRefreshToken($clientConfigId, Context $context)
    {
        if (!isset($_SESSION['php-oauth-client']['refresh_token'])) {
            return false;
        }

        foreach ($_SESSION['php-oauth-client']['refresh_token'] as $t) {
            $token = unserialize($t);
            if ($clientConfigId !== $token->getClientConfigId()) {
                continue;
            }
            if ($context->getUserId() !== $token->getUserId()) {
                continue;
            }
            if (!$token->getScope()->hasScope($context->getScope())) {
                continue;
            }

            return $token;
        }

        return false;
    }

    public function storeRefreshToken(RefreshToken $refreshToken)
    {
        if (!isset($_SESSION['php-oauth-client']['refresh_token'])) {
            $_SESSION['php-oauth-client']['refresh_token'] = array();
        }

        array_push($_SESSION['php-oauth-client']['refresh_token'], serialize($refreshToken));

        return true;
    }

    public function deleteRefreshToken(RefreshToken $refreshToken)
    {
        if (!isset($_SESSION['php-oauth-client']['refresh_token'])) {
            return false;
        }

        foreach ($_SESSION['php-oauth-client']['refresh_token'] as $k => $t) {
            $token = unserialize($t);
            if ($refreshToken->getRefreshToken() !== $token->getRefreshToken()) {
                continue;
            }
            unset($_SESSION['php-oauth-client']['refresh_token'][$k]);

            return true;
        }

        return false;
    }

    public function getState($clientConfigId, $state)
    {
        if (!isset($_SESSION['php-oauth-client']['state'])) {
            return false;
        }

        foreach ($_SESSION['php-oauth-client']['state'] as $s) {
            $sessionState = unserialize($s);

            if ($clientConfigId !== $sessionState->getClientConfigId()) {
                continue;
            }
            if ($state !== $sessionState->getState()) {
                continue;
            }

            return $sessionState;
        }

        return false;
    }

    public function storeState(State $state)
    {
        if (!isset($_SESSION['php-oauth-client']['state'])) {
            $_SESSION['php-oauth-client']['state'] = array();
        }

        array_push($_SESSION['php-oauth-client']['state'], serialize($state));

        return true;
    }

    public function deleteStateForContext($clientConfigId, Context $context)
    {
        if (!isset($_SESSION['php-oauth-client']['state'])) {
            return false;
        }

        foreach ($_SESSION['php-oauth-client']['state'] as $k => $s) {
            $sessionState = unserialize($s);
            if ($clientConfigId !== $sessionState->getClientConfigId()) {
                continue;
            }
            if ($context->getUserId() !== $sessionState->getUserId()) {
                continue;
            }
            unset($_SESSION['php-oauth-client']['state'][$k]);

            return true;
        }

        return false;
    }

    public function deleteState(State $state)
    {
        if (!isset($_SESSION['php-oauth-client']['state'])) {
            return false;
        }

        foreach ($_SESSION['php-oauth-client']['state'] as $k => $s) {
            $sessionState = unserialize($s);
            if ($state->getState() !== $sessionState->getState()) {
                continue;
            }
            unset($_SESSION['php-oauth-client']['state'][$k]);

            return true;
        }

        return false;
    }
}
