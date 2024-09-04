<?php

declare(strict_types=1);

namespace AlazziAz\Tamara\Tamara\Notification;

use AlazziAz\Tamara\Tamara\Notification\Exception\ForbiddenException;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Symfony\Component\HttpFoundation\Request;
use Illuminate\Support\Facades\Log;
use Firebase\JWT\SignatureInvalidException;
use Firebase\JWT\ExpiredException;

use Throwable;

class Authenticator
{
    private const AUTHORIZATION = 'Authorization';

    private const TOKEN = 'tamaraToken';

    /**
     * @var string
     */
    private $tokenKey;

    public function __construct(string $tokenKey)
    {
        $this->tokenKey = $tokenKey;
    }

    /**
     * @throws ForbiddenException
     */
    public function authenticate(Request $request): void
    {
        if (! $request->headers->has(self::AUTHORIZATION) && ! $request->get(self::TOKEN)) {
            throw new ForbiddenException('Access denied.');
        }

        $token = $request->get(self::TOKEN);

        try {
            $this->decode($token);
        } catch (Throwable $exception) {
            $msg = $exception->getMessage();
            throw new ForbiddenException('Access denied. ' . $msg);
        }
    }

    protected function getBearerToken(string $authorizationHeader): string
    {
        if (! empty($authorizationHeader) && preg_match('/Bearer\s(\S+)/', $authorizationHeader, $matches)) {
            return $matches[1];
        }

        throw new ForbiddenException('Access denied.');
    }

    /**
     * @throws ExpiredException
     * @throws SignatureInvalidException
     * @throws \Exception
     * @return bool
     */
    protected function decode(string $token)
    {
        try{
            JWT::decode($token, new Key($this->tokenKey, 'HS256'));
        }
        catch (ExpiredException $e) {
            Log::channel('tamara')->info('token expired');
            throw new ExpiredException();
        }
        catch (SignatureInvalidException $e) {
            Log::channel('tamara')->info('token invalid');
            throw new SignatureInvalidException();
        }
        catch (\Exception $e) {
            Log::channel('tamara')->info('token error');
            throw new \Exception();
        }
        return true;
    }
}
