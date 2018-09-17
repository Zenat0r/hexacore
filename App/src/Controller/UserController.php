<?php

namespace App\Controller;

use Hexacore\Core\Controller;
use Hexacore\Core\Response\Response;
use App\Model\UserModel;
use Hexacore\Core\Auth\Auth;

class UserController extends Controller
{
    public function index(UserModel $userModel): Response
    {
        $allUsers = $userModel->get();

        return $this->render("user/index.php", [
            "users" => $allUsers
        ]);
    }

    public function show(UserModel $userModel, int $id = 0): Response
    {
        $result = $userModel->getSingle("id", $id);

        if ($result == null) {
            return new Response("not found");
        }

        return $this->render("user/show.php", [
            "user" => $result
        ]);
    }

    public function del(UserModel $userModel, int $id = 0): Response
    {
        if ($this->isGranted($this->request->getSession(), Auth::defaultRole)) {
            $userModel->where("id", $id)->delete();

            return new Response("", [
                "location" => "http://localhost/user"
            ]);
        } else {
            return new Response("Not allowed");
        }
    }

    public function create(UserModel $userModel, string $name): Response
    {
        if ($this->isGranted($this->request->getSession(), Auth::defaultRole)) {
            $userModel->set("name", $name)
                    ->insert();

            return new Response("", [
                "location" => "http://localhost/user"
            ]);
        } else {
            return new Response("Not allowed");
        }
    }

    public function update(UserModel $userModel, int $id, string $name)
    {
        if ($this->isGranted($this->request->getSession(), Auth::defaultRole)) {
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
