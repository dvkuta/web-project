<?php

declare(strict_types=1);

namespace App\Presenters;

use App\Model\World;
use Nette;
use Nette\Application\UI\Form;


class LulPresenter extends Nette\Application\UI\Presenter
{
    public function __construct(
        private World $world,
	) {}

    protected function createComponentForm(): Form
    {
        $form = new Form;
        $country = $form->addSelect('country', 'Stát:', $this->world->getCountries())
        ->setPrompt('----')
        ->setHtmlAttribute('class',"form-control");


        $items = [];
        foreach ($this->world->getCountries() as $id => $name) {
            $items[$id] = $this->world->getCities($id);
        }
        bdump($items);
        //quick fix na bla bla bu bu
        //uu ii uu aaa
        //bla bla
        //no ne no
        $city = $form->addMultiSelect('city', 'Město:')
            //->setHtmlAttribute('data-depends', $country->getHtmlName())
            //->setHtmlAttribute('data-items', $items);
            ->setHtmlAttribute('data-depends', $country->getHtmlName())
            ->setHtmlAttribute('data-url', $this->link('Endpoint:cities', '#'))
            ->setHtmlAttribute('class=" selectpicker"');

        $form->addMultiSelect('lul', 'Lul:');

        $form->addMultiSelect("members", "Omegalul", [1,2,3,4])
            ->addRule($form::MAX_LENGTH, 'Můžou být vybrány maximálně 3 předvolby', 3)
            ->setHtmlAttribute('class=" selectpicker"');

        $form->onAnchor[] = fn() =>
        $city->setItems($country->getValue()
            ? $this->world->getCities($country->getValue())
            : []);

        $form->addSubmit("save","Uložit");

         $form->onSuccess[] = function (Nette\Utils\ArrayHash $values) {
            bdump($values);
    };
        return $form;
    }
}