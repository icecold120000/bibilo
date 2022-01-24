<?php

namespace App\Form;

use App\Entity\Bibliothecque;
use App\Entity\Livre;
use App\Repository\BibliothecqueRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class LivreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titreLivre', TextType::class,[
                'label' => 'Nom du livre',
                'required' => true,
            ])
            ->add('genreLivre', ChoiceType::class, [
                'label' => 'Genre du livre',
                'choices' => [
                    'Aventure' => 'Adventure',
                    'Horreur' => 'Horreur',
                    'Action' => 'Action',
                    'Romance' => 'Romance',
                ],
                'required' => false,
            ])
            ->add('dateLivre', DateType::class, [
                'label' => 'Date de publication du livre',
                'help' => 'Format : JJ/MM/AAAA.',
                'html5' => false,
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy',
                'required' => true,
                'invalid_message' => 'Votre saisie n\'est pas une date !',
            ])
            ->add('afficheLivre', FileType::class, [
                'label' => 'L\'affiche du livre ',
                'help' => 'Type de fichier supporté : png, jpg ou jpeg.',
                'mapped' => false,
                'required' => true,
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/png',
                            'image/jpeg',
                        ],
                        'mimeTypesMessage' => 'Veuillez selection un fichier .png/.jpeg/.jpg !',
                        'maxSizeMessage' => 'Veuillez transfer un fichier ayant pour taille maximum de {{limit}} !',
                    ])
                ],
            ])
            ->add('noteLivre', NumberType::class,[
                'label' => 'Coût de l\'événement',
                'invalid_message' => 'Veuillez saisir un nombre !',
                'required' => false,
            ])
            ->add('commentaireLivre', TextAreaType::class,[
                'label' => 'Commentaire sur le livre',
                'required' => false,
            ])
            ->add('bibliothecque', EntityType::class,[
                'label' => 'La bibliothèque auquel on peut trouver le livre',
                'class' => Bibliothecque::class,
                'query_builder' => function (BibliothecqueRepository $er) {
                    return $er->createQueryBuilder('te')
                        ->orderBy('te.id', 'ASC');
                },
                'choice_label' => 'nomBiblio',
                'required' => true,
                'empty_data' => '1',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Livre::class,
            'attr' => ['id' => 'formLivre']
        ]);
    }
}
