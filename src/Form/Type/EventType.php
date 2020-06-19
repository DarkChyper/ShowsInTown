<?php


namespace App\Form\Type;


use App\Entity\Artist;
use App\Entity\City;

use App\Repository\ArtistRepository;
use App\Repository\CityRepository;
use App\Repository\EventRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Contracts\Translation\TranslatorInterface;


class EventType extends AbstractType
{

    protected $translator;
    protected $cityRepository;
    protected $artistRepository;


    /**
     * EventType constructor.
     * @param TranslatorInterface $translator
     * @param CityRepository $cityRepository
     */
    public function __construct(TranslatorInterface $translator, CityRepository $cityRepository, ArtistRepository $artistRepository)
    {
        $this->translator = $translator;
        $this->cityRepository = $cityRepository;
        $this->artistRepository = $artistRepository;
    }


    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $cityChoice = $this->resolveCity($options);
        $artistChoice = $this->resolveArtist($options);

        $builder
            ->add('id', IntegerType::class, [
                'label' => false,
                'required' => false,
            ])
            ->add('date', DateType::class, [
                'label' => false,
                'required' => true,
                'widget' => 'single_text',
                'html5' => false,
                'format' => $this->translator->trans('form.edit.event.date.format')

            ])
            ->add('city', EntityType::class, [
                'class' => City::class,
                'choice_label' => 'name',
                'multiple' => false,
                'preferred_choices' => [$this->cityRepository->find($cityChoice)]
            ])
            ->add('artist', EntityType::class, [
                'class' => Artist::class,
                'choice_label' => 'name',
                'multiple' => false,
                'preferred_choices' => [$this->artistRepository->find($artistChoice)]
            ]);
    }

    /**
     * @param array $options
     * @return string
     */
    protected function resolveCity(array $options){
        return $options['data']->getCityChoice() === null ? '1': $options['data']->getCityChoice();
    }

    /**
     * @param array $options
     * @return string
     */
    protected function resolveArtist(array $options){
        return $options['data']->getArtistChoice() === null ? '1': $options['data']->getArtistChoice();
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'App\Entity\Event',
        ));
    }
}