<?php

declare(strict_types=1);

namespace App\Presenters;

use App\Model\World;
use Nette;
use Nette\Application\UI\Form;


class TruePresenter extends Nette\Application\UI\Presenter
{

    public function renderDefault(){
         $this->template->helloMessage = new Nette\Utils\DateTime();
    }

}