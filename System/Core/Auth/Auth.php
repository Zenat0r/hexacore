<?php

namespace Hexacore\Core\Auth;

use Hexacore\Core\Annotation\AnnotationableInterface;
use Hexacore\Core\Annotation\Type\AnnotationType;
use Hexacore\Core\Config\JsonConfig;
use Hexacore\Core\Exception\Auth\InvalidRoleAuthException;
use Hexacore\Core\Exception\Auth\UnauthorizedAuthException;
use Hexacore\Core\Request\RequestInterface;
use Hexacore\Core\Response\Response;

/**
 * Class Auth
 * @package Hexacore\Core\Auth
 */
class Auth implements AuthInterface, AnnotationableInterface
{
    const DEFAULT_ROLE = "ANONYMOUS";
    const ANNOTATION_NAME = "Auth";

    private $roles;
    private static $storage;

    public function __construct()
    {
        $this->roles = JsonConfig::get("app")["Auth"]["roles"] ?? [];
        array_push($this->roles, Auth::DEFAULT_ROLE);
    }

    /**
     * @param string $role
     * @return bool
     * @throws \Exception
     */
    public function isGranted(string $role) : bool
    {
        $role = strtoupper($role);
        if (!in_array($role, $this->roles)) {
            throw new InvalidRoleAuthException("Role doesn't exist", Response::UNAUTHORIZED);
        }

        if (self::$storage->get("USER_ROLE") === $role) {
            return true;
        }

        return false;
    }

    /**
     * @return string|null
     */
    public function getToken() : ?string
    {
        $token = self::$storage->get("token") ?? null;

        return $token;
    }

    public function authenticate(RequestInterface $request) : void
    {
        self::$storage = $request->getSession();
        $token = $this->getToken();

        if (null === $token) {
            self::$storage->add("token", md5(uniqid()));

            self::$storage->add("USER_ROLE", Auth::DEFAULT_ROLE);
        }
    }

    /**
     * @param string $role
     */
    public function setRole(string $role): void
    {
        self::$storage->add("USER_ROLE", $role);
    }

    /**
     * @param AnnotationType $annotationType
     * @return bool
     */
    public function isValidAnnotationType(AnnotationType $annotationType): bool
    {
        return $annotationType->getKey() === $this->getAnnotationName() && !empty($annotationType->getValue());
    }

    /**
     * @param AnnotationType $annotationType
     * @throws \Exception
     */
    public function process(AnnotationType $annotationType): void
    {
        $role = $annotationType->getValue();
        $authorized = false;

        if (!is_array($role)) {
            $role = [$role];
        }

        foreach ($role as $r) {
            if ($this->isGranted($r)) {
                $authorized = true;
            }
        }

        if (!$authorized) {
            throw new UnauthorizedAuthException("Connection unauthorized", Response::FORBIDDEN);
        }
    }

    /**
     * @return string
     */
    public function getAnnotationName(): string
    {
        return self::ANNOTATION_NAME;
    }
}
