export function setId($elem) {


    if ($elem.id !== '') {
        return $elem.id;
    } else {
        let newId = 'id_' + getRandomInt(1000, 10000);
        $elem.id = newId;
        return newId;
    }

    function getRandomInt(min, max) {
        min = Math.ceil(min);
        max = Math.floor(max);
        return Math.floor(Math.random() * (max - min)) + min; //Максимум не включается, минимум включается
    }
}
