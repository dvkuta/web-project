<?php

declare(strict_types=1);

namespace App\Presenters;

use App\Model\World;
use Nette;
use Nette\Application\UI\Form;



class EndpointPresenter extends Nette\Application\UI\Presenter
{
public function __construct(
private World $world,
) {}

public function actionCities($country): void
{
$cities = $this->world->getCities($country);
$this->sendJson($cities);
}
}