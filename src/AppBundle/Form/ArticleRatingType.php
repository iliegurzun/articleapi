<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use AppBundle\Form\DataTransformer\UserToStringTransformer;
use AppBundle\Form\DataTransformer\ArticleToStringTransformer;

class ArticleRatingType extends AbstractType 
{
    protected $userRepository;
    
    protected $articleRepository;


    public function __construct($userRepository, $articleRepository) 
    {
        $this->userRepository = $userRepository;
        $this->articleRepository = $articleRepository;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('rating')
            ->add('user', 'text', array(
                // validation message if the data transformer fails
                'invalid_message' => 'That is not a valid username',
            ))
            ->add('article', 'text', array(
                // validation message if the data transformer fails
                'invalid_message' => 'This article does not exists',
            ))
        ;
        $builder->get('user')
            ->addModelTransformer(new UserToStringTransformer($this->userRepository));
    
        $builder->get('article')
            ->addModelTransformer(new ArticleToStringTransformer($this->articleRepository));
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\ArticleRating',
            'csrf_protection'   => false
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'article_rating';
    }
}