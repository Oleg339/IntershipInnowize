<?php

namespace Controller\Api;

include_once('Validator.php');
include_once('Model/User.php');
include_once('Response.php');

use Model\User;
use Response;
use Validator;

class UserController
{
    public function index()
    {
        Response::json(User::all(), 200);
    }

    public function store($request)
    {
        $validator = new Validator($request->get());

        $isValidated = $validator->validate([
            'gender' => ['required'],
            'status' => ['required'],
            'email' => ['required', 'email'],
            'name' => ['required', 'length:4,20', 'string']
        ]);

        if (!$isValidated) {
            return Response::json(['messages' => $validator->getErrors()], 400);
        }

        $user = new User($validator->getValidated());
        $user->save();

        Response::json($user->getValues(), 201);
    }

    public function delete($request, $id)
    {
        $user = User::find($id);

        if(!$user){
            return Response::notFound();
        }

        $user->delete();

        Response::json([], 204);
    }

    public function show($request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return Response::notFound();
        }

        Response::json($user->getValues(), 200);
    }

    public function update($request, $id)
    {
        $request = $request->get();

        if (!User::find($id)) {
            return Response::notFound();
        }

        $validator = new Validator(array_merge($request, ['id' => $id]));

        $isValidated = $validator->validate([
            'gender' => ['required'],
            'status' => ['required'],
            'email' => ['required', 'email'],
            'name' => ['required', 'length:4,20', 'string']
        ]);

        if (!$isValidated) {
            return Response::json(['messages' => $validator->getErrors()], 400);
        }

        $user = new User(array_merge($validator->getValidated(), ['id' => $id]));
        $user->update();

        Response::json($user->getValues(), 200);
    }
}
