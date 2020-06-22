<?php


namespace App\Service;


use App\Entity\City;
use App\Repository\CityRepository;

class CityService
{
    /**
     * @var CityRepository
     */
    protected $cityRepository;

    /**
     * EventFilterType constructor.
     * @param CityRepository $cityRepository
     */
    public function __construct(CityRepository $cityRepository)
    {
        $this->cityRepository = $cityRepository;
    }
    /**
     * Return an array with cities id => name and one element empty
     * @return array
     */
    public function getCityChoiceList(){
        $result = array();
        $result[""] = "0";

        $cities = $this->cityRepository->findAll();
        if(!empty($cities)){
            foreach ($cities as $cle => $city){
                if($city instanceof City){
                    $result[$city->getName()] = $city->getId();
                }
            }
        }

        return $result;
    }
}