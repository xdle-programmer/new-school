import {tns} from "tiny-slider";

if (document.querySelector('.group-numbers__items')) {

    let slider = tns({
        container: '.group-numbers__items',
        items: 2,
        mouseDrag: true,
        arrowKeys: true,
        controls:true,
        responsive: {
            1280: {
                items: 6
            },
            // 700: {
            //     gutter: 30
            // },
            // 900: {
            //     items: 1
            // }
        }
    });
}
