<?php

namespace AppBundle\Form\Type;

use AppBundle\Entity\Event;
use AppBundle\Form\DataTransformer\DateTimeToStringTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventType extends AbstractType
{
    /**
     * @var DateTimeToStringTransformer
     */
    private $transformer;

    public function __construct(DateTimeToStringTransformer $transformer)
    {
        $this->transformer = $transformer;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'date',
                TextType::class,
                [
                    'label' => 'form.labels.date',
                    'attr'  =>
                        [
                            'class'       => 'js-datetime-picker datetimepicker-input',
                            'data-toggle' => 'datetimepicker',
                            'data-target' => '.js-datetime-picker',
                        ],
                ]
            )
            ->add('isDateOnly', CheckboxType::class, ['required' => false, 'label' => 'form.labels.is_date_only'])
            ->add('label', TextType::class, ['label' => 'form.labels.label'])
            ->add('description', TextareaType::class, ['required' => false, 'label' => 'form.labels.description'])
            ->add('private', CheckboxType::class, ['required' => false, 'label' => 'form.labels.private']);

        $builder->get('date')->addModelTransformer($this->transformer);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class'         => Event::class,
                'translation_domain' => 'messages',
            ]
        );
    }
}
