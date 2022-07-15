<?php

namespace App\Model;

class World
{
public function getCountries(): array
{
return ["Česko", "Slovensko", "Německo"];
}

public function getCities($country): array
{
    $cities = [["Praha", "Olomouc", "Brno"],["Košice", "Bratislava", "Liptovský mikuláš"], ["Berlín", "Mitterteich", "Waldsassen"]];
    return $cities[$country];
}

}