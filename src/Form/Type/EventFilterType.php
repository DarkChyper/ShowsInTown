<?php


namespace App\Form\Type;




use App\Entity\City;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Contracts\Translation\TranslatorInterface;

class EventFilterType extends AbstractType
{
    /**
     * @var TranslatorInterface
     */
    protected $translator;

    /**
     * EventFilterType constructor.
     * @param TranslatorInterface $translator
     */
    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fromDate', DateType::class,[
                'label' => false,
                'required' => false,
                'widget' => 'single_text',
                'html5' => false,
                'format' => $this->translator->trans('form.edit.event.date.format')
            ])
            ->add('toDate', DateType::class,[
                'label' => false,
                'required' => false,
                'widget' => 'single_text',
                'html5' => false,
                'format' => $this->translator->trans('form.edit.event.date.format')
            ])
            ->add('city', EntityType::class,[
                'class' => City::class,
                'required' => false,
                'label' => false,
                'choice_label' => 'name',
                'multiple' => false,
            ])
            ->add('artist', TextType::class, [
                'required' => false,
                'label' => false
            ]);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'App\Entity\EventFilter',
        ));
    }

}