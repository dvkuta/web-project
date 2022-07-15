// najdeme na stránce všechny podřízené selectboxy
document.querySelectorAll('select[data-depends]').forEach((childSelect) => {
    let parentSelect = childSelect.form[childSelect.dataset.depends]; // nadřízený <select>
    let url = childSelect.dataset.url; // atribut data-url
    let items = JSON.parse(childSelect.dataset.items || 'null'); // atribut data-items

    // když uživatel změní vybranou položku v nadřízeném selectu...
    parentSelect.addEventListener('change', () => {
        // pokud existuje atribut data-items...
        if (items) {
            // nahrajeme rovnou do podřízeného selectboxu nové položky
            updateSelectbox(childSelect, items[parentSelect.value]);
        }

        // pokud existuje atribut data-url...
        if (url) {
            // uděláme AJAXový požadavek na endpoint s vybranou položkou místo placeholderu
            fetch(url.replace(encodeURIComponent('#'), encodeURIComponent(parentSelect.value)))
                .then((response) => response.json())
                // a nahrajeme do podřízeného selectboxu nové položky
                .then((data) => updateSelectbox(childSelect, data));
        }
    });
});

// přepíše <options> v <select>
function updateSelectbox(select, items)
{
    select.innerHTML = ''; // odstraníme vše
    for (let id in items) { // vložíme nové
        let el = document.createElement('option');
        el.setAttribute('value', id);
        el.innerText = items[id];
        select.appendChild(el);
    }
    console.log(select.id);

    $('#'+select.id).selectpicker('refresh');
    console.log();
}