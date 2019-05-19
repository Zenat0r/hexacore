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
     * @Request\Method("GET", "POST")
     */
    public function index(ModelRepository $repository): ResponseInterface
    {
        $users = $repository->setModel(User::class)->findAll();

        return $this->render("user/index.php", [
            "users" => $users
        ]);
    }

    /**
     * @param User|null $user
     * @return ResponseInterface
     * @Request\Method("GET")
     */
    public function show(?User $user): ResponseInterface
    {
        if (null === $user) {
            return new Response("not found");
        }

        return $this->render("user/show.php", [
            "user" => $user
        ]);
    }

    /**
     * @param ModelManager $modelManager
     * @param Url $url
     * @param User|null $user
     * @return Response
     * @throws \ReflectionException
     * @Auth("ADMIN_USER")
     * @Request\Method("GET")
     */
    public function del(ModelManager $modelManager, Url $url, ?User $user): Response
    {
        if ($this->isGranted(Auth::DEFAULT_ROLE)) {
            if (null === $user) {
                return new Response("No user to delete");
            }

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
     * @Auth("ADMIN_USER")
     * @Request\Method("GET")
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
     * @param Url $url
     * @param User|null $user
     * @param string $name
     * @return Response
     * @throws \ReflectionException
     * @Auth("ADMIN_USER")
     * @Request\Method("GET")
     */
    public function update(ModelManager $modelManager, Url $url, ?User $user, string $name)
    {
        if ($this->isGranted(Auth::DEFAULT_ROLE)) {
            if (null === $user) {
                return new Response("No user to update");
            }

            $user->setName($name);

            $modelManager->persist($user);

            return new RedirectionResponse($url->baseUrl("user"));
        } else {
            return new Response("Not allowed");
        }
    }
}
