<?php

declare(strict_types=1);

namespace App\Presenters;

use Nette;
use NasExt;
use Nette\Application\UI\Form;


final class HomepagePresenter extends Nette\Application\UI\Presenter
{

    protected function createComponentRegistrationForm(): Form
    {
        $form = new Form;
        $form->addText('name', 'Jméno:');
        $form->addPassword('password', 'Heslo:');

        $country = [
            1 => 'Slovakia',
            2 => 'Czechia',
            3 => 'USA',
        ];

        $citySlovakia = [
            1 => 'Bratislaba',
            2 => 'Kosice',
            3 => 'Zilina',
        ];

        $cityCzechia = [
            1 => 'Praha',
            2 => 'Brno',
            3 => 'Ostrava',
        ];

        $cityUsa = [
            1 => 'Toronto',
            2 => 'Philadelphia',
            3 => 'Boston',
        ];

        $street1 = [
            1 => 'street1-1',
            2 => 'street1-2',
            3 => 'street1-3',
        ];

        $street2 = [
            1 => 'street2-1',
            2 => 'street2-2',
            3 => 'street2-3',
        ];

        $street3 = [
            1 => 'street3-1',
            2 => 'street3-2',
            3 => 'street3-3',
        ];


        $form->addSelect('country', 'Country', $country)
            ->setPrompt('--- Select ---');

        $form->addText('text', 'Text')
            ->setAttribute('placeholder', 'Text');

        $form->addDependentSelectBox('city', 'City', $form['country'])
            ->setDependentCallback(function ($values) use ($citySlovakia, $cityCzechia, $cityUsa) {
                $data = new \NasExt\Forms\DependentData;

                if ($values['country'] === 1) {
                    $data->setItems($citySlovakia)->setPrompt('---');

                } elseif ($values['country'] === 2) {
                    $data->setItems($cityCzechia)->setPrompt('---');

                } elseif ($values['country'] === 3) {
                    $data->setItems($cityUsa)->setPrompt('---');
                }

                return $data;
            })
            ->setPrompt('--- Select country first ---');

        $form->addDependentSelectBox('street', 'Street', $form['city'], $form['text'])
            ->setDependentCallback(function ($values) use ($street1, $street2, $street3) {
                $data = new \NasExt\Forms\DependentData;

                if ($values['city'] === 1) {
                    if (!empty($values['text'])) {
                        $street1 = array_merge($street1, [10 => 'Value from Text input: ' . $values['text']]);
                    }

                    $data->setItems($street1);

                } elseif ($values['city'] === 2) {
                    if (!empty($values['text'])) {
                        $street2 = array_merge($street2, [10 => 'Value from Text input: ' . $values['text']]);
                    }

                    $data->setItems($street2);

                } elseif ($values['city'] === 3) {
                    if (!empty($values['text'])) {
                        $street3 = array_merge($street3, [10 => 'Value from Text input: ' . $values['text']]);
                    }

                    $data->setItems($street3);

                }
                    return $data;
                })
                ->setPrompt('--- Select ---');

        $form->addSubmit('send', 'Registrovat');
        $form->onSuccess[] = [$this, 'formSucceeded'];
        return $form;
    }

    public function formSucceeded(Form $form, $data): void
    {
        // tady zpracujeme data odeslaná formulářem
        // $data->name obsahuje jméno
        // $data->password obsahuje heslo
        $this->flashMessage('Byl jste úspěšně registrován.');
        $this->redirect('Homepage:');
    }

}
