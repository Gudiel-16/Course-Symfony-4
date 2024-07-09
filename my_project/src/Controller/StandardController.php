<?php

namespace App\Controller;

use App\Entity\Categoria;
use App\Entity\Producto;
use App\Form\ProductoType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StandardController extends AbstractController
{
    // Las rutas apuntan a un controlador, este caso a index()
    // index() retorna un template, templates->standard->index.html.twig

    // para hacer que esta sea la ruta principal solamente cambiar '/standard' por '/'

    /**
     * @Route("/", name="index")
     */
    public function index(Request $request): Response
    {

        $user = $this->getUser(); // si hay usuario logueado
        if($user){

            // creamos formulario
            $producto = new Producto();
            $form = $this->createForm(ProductoType::class, $producto);

            $num1 = 10;
            $num2 = 100;
            $suma = $num1 + $num2;
            $vocales = "a, E, i, O, u";

            // recibir datos del form
            $form->handleRequest($request);

            if($form->isSubmitted() && $form->isValid()){
                $em = $this->getDoctrine()->getManager();
                $producto = $form->getData(); // asignar valores en producto
                $em->persist($producto);
                $em->flush();
                return $this->redirectToRoute('index'); // redireccionamos al mismo index
            }

            return $this->render('standard/index.html.twig', 
                array(
                    'miSuma'=>$suma, 
                    'num1'=>$num1, 
                    'num2'=>$num2,
                    'vocales'=>$vocales,
                    'form' => $form->createView(),
                )    
            );
            
            // antes:
            // return $this->render('standard/index.html.twig', [
            //     // StandardController es un valor que se envia por medio como de la variable 'controller_name'
            //     'controller_name' => 'StandardController', 
            // ]);

        }else{
            // ruta: vendor->friendsofsymfony->user-bundle->resources->routing->security.xml
            return $this->redirectToRoute('fos_user_security_login'); // muestra el login
        }
    }

    /**
     * @Route("/pagina2/{nombre}/", name="pagina2")
     */
    public function pagina2(Request $request, $nombre){

        $form = $this->createFormBuilder()
                    ->add('nombre')
                    ->add('codigo')
                    ->add('categoria', EntityType::class, [
                        'class' => Categoria::class, // a que entidad hace referencia
                        'choice_label' => 'nombre' // se muestre con el campo nombre (sera un combobox)
                    ])
                    ->add('Enviar', SubmitType::class)
                    ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $data = $form->getData();
            $producto = new Producto($data['nombre'], $data['codigo']); // asignamos datos
            $producto->setCategoria($data['categoria']); // asignamos categoria
            $em->persist($producto);
            $em->flush();
            return $this->redirectToRoute('pagina2', ['nombre'=>'Guardado exitoso']);
        }

        // $this->render ubica automatico enla carpeta templates
        return $this->render('standard/pagina2.html.twig', array(
                                                            "parametro1"=>$nombre,
                                                            'form' => $form->createView()
                                                        ));
    }
    
    /**
     * @Route("/persistirDatos/", name="persistir")
     */
    public function persistirDatos(){

        // --------------- Guardando en DB manualmente (cuando aun no habia constructor)
        // $entityManager = $this->getDoctrine()->getManager();

        // $producto = new Producto();
        // $producto->setNombre("Mouse");
        // $producto->setCodigo("5678");

        // // guardamos en db
        // $entityManager->persist($producto);
        // $entityManager->flush();

        // --------------- Guardando en DB (con constructor)
        // $entityManager = $this->getDoctrine()->getManager();

        // $producto = new Producto('TV', '03');

        // // guardamos en db
        // $entityManager->persist($producto);
        // $entityManager->flush();

        $entityManager = $this->getDoctrine()->getManager();
        
        $categoria = new Categoria('Tecnologia');

        $producto = new Producto('TV LCD', '04');
        $producto->setCategoria($categoria);

        // guardamos en db
        $entityManager->persist($producto);
        $entityManager->flush();

        return $this->render('standard/success.html.twig');
    }

    /**
     * @Route("/busquedas/", name="busquedas")
     */
    public function busquedas(){

        $em = $this->getDoctrine()->getManager();

        $producto = $em->getRepository(Producto::class)->find(1); // busqueda por id
        $producto2 = $em->getRepository(Producto::class)->findOneBy(['codigo'=>'04']); // busqueda por algun campo
        $producto3 = $em->getRepository(Producto::class)->findBy(['categoria'=>2]); // retorna varios resultados, por criterio de busqueda
        $productos = $em->getRepository(Producto::class)->findAll(); // retorna todos

        $producoRepository = $em->getRepository(Producto::class)->buscarProductoPorIdPersonalizado(2);

        return $this->render('standard/busqueda.html.twig', array(
                                                                    'find'=>$producto, 
                                                                    'findOneBy'=>$producto2,
                                                                    'findBy'=>$producto3,
                                                                    'findAll'=>$productos,
                                                                    'buscarProductoPorIdPersonalizado'=>$producoRepository
                                                                ));
    }
        
}
