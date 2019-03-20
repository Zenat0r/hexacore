<?php

namespace App\Controller;

use App\Model\User;
use Hexacore\Core\Auth\Auth;
use Hexacore\Core\Controller;
use Hexacore\Core\Model\Manager\ModelManager;
use Hexacore\Core\Model\Repository\ModelRepository;
use Hexacore\Core\Response\Redirect\RedirectionResponse;
use Hexacore\Core\Response\Response;
use Hexacore\Core\Response\ResponseInterface;
use Hexacore\Helpers\Url;

class UserController extends Controller
{
    /**
     * @param ModelRepository $repository
     * @return ResponseInterface
     * @throws \Exception
     */
    public function index(ModelRepository $repository): ResponseInterface
    {
        $users = $repository->setModel(User::class)->findAll();

        return $this->render("user/index.php", [
            "users" => $users
        ]);
    }

    public function show(User $user, int $id): ResponseInterface
    {
        if ($user == null) {
            return new Response("not found");
        }

        return $this->render("user/show.php", [
            "user" => $user
        ]);
    }

    /**
     * @param ModelManager $modelManager
     * @param Url $url
     * @param User $user
     * @param int $id
     * @return Response
     * @throws \ReflectionException
     */
    public function del(ModelManager $modelManager, Url $url, User $user, int $id): Response
    {
        if ($this->isGranted(Auth::defaultRole)) {
            $modelManager->delete($user);

            return new RedirectionResponse($url->baseUrl("user"));
        } else {
            return new Response("Not allowed");
        }
    }

    /**
     * @param ModelManager $modelManager
     * @param string $name
     * @param Url $url
     * @return Response
     * @throws \ReflectionException
     */
    public function create(ModelManager $modelManager, string $name, Url $url): Response
    {
        $user = new User();
        $user->setName($name);

        $modelManager->persist($user);

        return new RedirectionResponse($url->baseUrl("user"));
    }

    /**
     * @param ModelManager $modelManager
     * @param User $user
     * @param int $id
     * @param string $name
     * @return Response
     * @throws \ReflectionException
     */
    public function update(ModelManager $modelManager, User $user, int $id, string $name)
    {
        if ($this->isGranted(Auth::defaultRole)) {
            $user->setName($name);

            $modelManager->persist($user);

            return new Response("", [
                "location" => "http://localhost/user"
            ]);
        } else {
            return new Response("Not allowed");
        }
    }
}
