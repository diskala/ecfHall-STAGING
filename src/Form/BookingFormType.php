<?php

namespace App\Form;

use App\Entity\Booking;
use App\Repository\EventTypeRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class BookingFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            //Fields not used in the form
            //Already set in the controller 
            // ->add('user')
            // ->add('room')
            // ->add('totalPrice')
            // ->add('status')

            //Add field eventType to the form booking/add.html.twig
            ->add('eventType', options:[
                'label' => 'Type d\'évènement',
                'required' => true,
                'query_builder' => function (EventTypeRepository $eTR) {
                    return $eTR->createQueryBuilder('e')
                        ->orderBy('e.name', 'ASC');
                },
            ])

            //Add field startDate to the form booking/add.html.twig
            ->add('startDate', options:[
                'label' => 'Date de début',
                'widget' => 'single_text',
                'required' => true,
            ])

            //Add field endDate to the form booking/add.html.twig
            ->add('endDate', options:[
                'label' => 'Date de fin',
                'widget' => 'single_text',
                'required' => true,
            ])

            //Add field comment to the form booking/add.html.twig
            ->add('comment',  TextareaType::class, options:[
                'label' => 'Commentaires',
                'required' => false,
                'attr' => [
                    'placeholder' => '...',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Booking::class,
        ]);
    }
}
