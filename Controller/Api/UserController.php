<?php

namespace Controller\Api;

include_once('Validator.php');
include_once('Model/User.php');
include_once('Response.php');

use Model\User;

class UserController
{
    public function index()
    {
        \Response::sendData(User::all());
    }

    public function store($request)
    {
        $validator = new \Validator($request->get());

        $isValidated = $validator->validate([
            'gender' => ['required'],
            'status' => ['required'],
            'email' => ['required', 'email'],
            'name' => ['required', 'length:4,20', 'string']
        ]);

        if ($isValidated) {
            $user = new User($validator->getValidated());
            $user->save();

            \Response::sendData($user->getValues());

            return;
        }

        \Response::validationError($validator->getErrors());
    }

    public function delete($request, $id)
    {
        if (!User::find($id)->delete()) {
            \Response::notFound();
        }

        \Response::success();
    }

    public function show($request, $id)
    {
        $user = User::find($id);

        if ($user) {
            \Response::sendData($user->getValues());

            return;
        }

        \Response::notFound();
    }

    public function update($request, $id): void
    {
        $request = $request->get();

        if (!User::find($id)) {
            \Response::notFound();

            return;
        }

        $validator = new \Validator(array_merge($request, ['id' => $id]));

        $isValidated = $validator->validate([
            'gender' => ['required'],
            'status' => ['required'],
            'email' => ['required', 'email'],
            'name' => ['required', 'length:4,20', 'string']
        ]);

        if ($isValidated) {
            $user = new User(array_merge($validator->getValidated(), ['id' => $id]));
            $user->update();
            \Response::sendData($user->getValues());

            return;
        }

        \Response::validationError($validator->getErrors());
    }
}
