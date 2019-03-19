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

    public function show(ModelRepository $modelRepository, int $id = 0): ResponseInterface
    {
        $user = $modelRepository->setModel(User::class)->findById($id);

        if ($user == null) {
            return new Response("not found");
        }

        return $this->render("user/show.php", [
            "user" => $user
        ]);
    }

    /**
     * @param ModelManager $modelManager
     * @param ModelRepository $modelRepository
     * @param int $id
     * @param Url $url
     * @return Response
     * @throws \Exception
     */
    public function del(ModelManager $modelManager, ModelRepository $modelRepository, int $id = 0, Url $url): Response
    {
        if ($this->isGranted(Auth::defaultRole)) {
            $user = $modelRepository->setModel(User::class)->findById($id);
            $modelManager->delete($user);

            return new RedirectionResponse($url->baseUrl("user"));
        } else {
            return new Response("Not allowed");
        }
    }

    /**
     * @param ModelManager $modelManager
     * @param string $name
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

    public function update(User $userModel, int $id, string $name)
    {
        if ($this->isGranted(Auth::defaultRole)) {
            /*$userModel->set("name", $name)
                    ->where("id", $id)
                    ->update();*/

            $user = $userModel->getObject($id);
            $user->add("name", $name);

            return new Response("", [
                "location" => "http://localhost/user"
            ]);
        } else {
            return new Response("Not allowed");
        }
    }
}
