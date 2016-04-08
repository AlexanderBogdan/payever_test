<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AlbumController extends Controller
{

    /**
     * @Route("/", name="home")
     * Entry point for SPA.
     */
    public function frontPage() {

        return $this->render('default/index.html.twig');
    }

    /**
     * @Route("/albums")
     * Albums list
     */
    public function getAlbums(){
        try {
            $albums = $this->getDoctrine()
                ->getRepository('AppBundle:Album')->findAll();

            if (is_null($albums)){
                throw new NotFoundHttpException('Not found');
            }

            $data = array(
                'success' => TRUE,
                'data' => $albums,
            );

            $serializer = $this->get('app.serializer.default')->serialize($data, 'json');

            $response = new Response($serializer);
            $response->headers->set('Content-Type', 'application/json');
            return $response;

        } catch (\Exception $exception) {

            return new JsonResponse([
                'success' => false,
                'code'    => $exception->getCode(),
                'message' => $exception->getMessage(),
            ]);
        }
    }

    /**
     * @Route("/albums/{id}", name="albums_id")
     * Get Album by id
     */
    public function getAlbumById(Request $request, $id){
        try {
            $album = $this->getDoctrine()
                ->getRepository('AppBundle:Album')->find($id);

            if (is_null($album)) {
                throw new NotFoundHttpException('Not found');
            }

            $collection = $album->getImages();
            $paginator  = $this->get('knp_paginator');

            $pagination = $paginator->paginate(
                $collection,
                $request->query->getInt('page', 1),
                10
            );

            $pager = $pagination->getPaginationData();

            $data = array(
                'success' => true,
                'data' => $album,
                'pager' => $pager,
            );

            $result = $this->get('app.serializer.default')->serialize($data, 'json', array('pager' => $pager));

            $response = new Response($result);
            $response->headers->set('Content-Type', 'application/json');
            return $response;

        } catch (\Exception $exception) {

            return new JsonResponse([
                'success' => false,
                'code'    => $exception->getCode(),
                'message' => $exception->getMessage(),
            ]);
        }
    }

//    /**
//     * @Route("/albums/{id}/images", name="albums_image")
//     * Get All images from album
//     */
//    public function getAllAlbumImages(Request $request, $id){
//        try {
//            $images = $this->getDoctrine()
//                ->getRepository('AppBundle:Image')->getImagesByAlbumId($id);
//
//            $success = false;
//
//            if(!is_null($images)){
//                $success = true;
//            }
//
//            $paginator  = $this->get('knp_paginator');
//
//            $pagination = $paginator->paginate(
//                $images, /* query NOT result */
//                $request->query->getInt('page', 1),
//                10
//            );
//
//            return new JsonResponse([
//                'success' => $success,
//                'pager' => $pagination->getPaginationData(),
//                'data' => $pagination->getItems(),
//            ]);
//
//        } catch (\Exception $exception) {
//
//            return new JsonResponse([
//                'success' => false,
//                'code'    => $exception->getCode(),
//                'message' => $exception->getMessage(),
//            ]);
//        }
//    }

}