<?php

namespace App\Gamers\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class IndexController
{
    public function listAction(Request $request, Application $app)
    {
        $gamers = $app['repository.gamer']->getAll();
        $users = $app['repository.user']->getAll();
        return $app['twig']->render('gamers.list.html.twig', array('gamers' => $gamers,'users' => $users));
    }

	public function displayAction(Request $request, Application $app)
    {

        $parameters = $request->attributes->all();
        $users = $app['repository.gamer']->getAllUsers($parameters['id']);
        return $app['twig']->render('gamers.display.html.twig', array('users' => $users));
    }


    public function deleteAction(Request $request, Application $app)
    {
        $parameters = $request->attributes->all();
        $app['repository.gamer']->delete($parameters['id']);

        return $app->redirect($app['url_generator']->generate('gamers.list'));
    }

    public function editAction(Request $request, Application $app)
    {
        $parameters = $request->attributes->all();
        $gamer = $app['repository.gamer']->getById($parameters['id']);

        return $app['twig']->render('gamers.form.html.twig', array('gamer' => $gamer));
    }

    public function saveAction(Request $request, Application $app)
    {
        $parameters = $request->request->all();
        if ($parameters['id']) {
            $gamer = $app['repository.gamer']->update($parameters);
        } else {
            $gamer = $app['repository.gamer']->insert($parameters);
        }

        return $app->redirect($app['url_generator']->generate('gamers.list'));
    }

    public function newAction(Request $request, Application $app)
    {
        return $app['twig']->render('gamers.form.html.twig');
    }

    public function responseAction(Request $request, Application $app) 
    {
        $content = 'john';
        $myJSON = json_encode($content);
      //  echo $myJSON;
       var_dump($content);
        return new Response($myJSON,Response::HTTP_OK,array('Content-type' => 'application/json'));
    }


    /* response 
        return new Response($content,&statutCode,&header)
        header["Content-type : application/json"]

    */
}
